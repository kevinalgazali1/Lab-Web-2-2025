<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\ProductWarehouse; // Model pivot kita
use Illuminate\Support\Facades\DB; // Untuk transaksi

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::orderBy('name')->get();

        $query = ProductWarehouse::with('product', 'warehouse')
                                 ->orderBy('warehouse_id');

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        $stocks = $query->paginate(10)->appends($request->query());

        return view('stocks.index', compact('stocks', 'warehouses'));
    }

    public function transfer()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    public function processTransfer(Request $request)
    {
        $validatedData = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|not_in:0', 
        ]);

        $warehouseId = $validatedData['warehouse_id'];
        $productId = $validatedData['product_id'];
        $transferQty = (int) $validatedData['quantity']; // Misal: +10 atau -5

        // 2. Gunakan Transaksi Database
        // Ini memastikan jika ada error, data tidak akan tersimpan setengah-setengah
        DB::beginTransaction();
        try {
            // 3. Ambil data stok saat ini, atau buat baru jika belum ada
            // (default stok 0 jika produk baru masuk gudang)
            $stock = ProductWarehouse::firstOrCreate(
                [
                    'product_id' => $productId,
                    'warehouse_id' => $warehouseId
                ],
                ['quantity' => 0] // Nilai default jika data baru
            );

            // 4. Hitung level stok yang baru
            $newStockLevel = $stock->quantity + $transferQty;

            // 5. ATURAN BISNIS: "stok di suatu gudang jangan sampai minus"
            if ($newStockLevel < 0) {
                // Batalkan transaksi dan kirim pesan error
                DB::rollBack();
                return back()
                    ->with('error', 'Gagal! Stok tidak bisa minus. Stok saat ini: ' . $stock->quantity)
                    ->withInput(); // Mengembalikan input user sebelumnya
            }

            // 6. Simpan data stok yang baru
            $stock->quantity = $newStockLevel;
            $stock->save();

            // 7. Jika semua sukses, commit ke database
            DB::commit();

        } catch (\Exception $e) {
            // 8. Tangani jika ada error lain (misal database mati)
            DB::rollBack();
            return back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }

        // 9. Redirect kembali ke halaman transfer dengan pesan sukses
        return redirect()->route('stocks.transfer')
                         ->with('success', 'Transfer stok berhasil!');
    }
}
