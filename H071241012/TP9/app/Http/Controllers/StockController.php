<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::all();
        $selectedWarehouseId = $request->input('warehouse_id');

        $products = collect([]);
        $selectedWarehouse = null;

        if ($selectedWarehouseId) {
            $selectedWarehouse = Warehouse::find($selectedWarehouseId);
            if ($selectedWarehouse) {
                // Ambil semua produk di gudang terpilih, termasuk quantity dari pivot table
                $products = $selectedWarehouse->products()->withPivot('quantity')->get();
            }
        }
        
        return view('stocks.index', compact('warehouses', 'selectedWarehouse', 'products'));
    }

    // transferStok: Menampilkan form Transfer Stok 
    public function transferStokForm()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    // processTransferStok: Memproses penambahan/pengurangan stok 
    public function processTransferStok(Request $request)
    {
       // Validasi
    $request->validate([
        'warehouse_id' => 'required|exists:warehouses,id',
        'product_id' => 'required|exists:products,id',
        'stock_value' => 'required|integer', // Menerima nilai positif atau negatif
    ]);

    $warehouseId = $request->warehouse_id;
    $productId = $request->product_id;
    $stockChange = $request->stock_value;

    DB::transaction(function () use ($warehouseId, $productId, $stockChange) {
        $warehouse = Warehouse::find($warehouseId);
        $product = Product::find($productId);

        $pivotData = $warehouse->products()->where('product_id', $productId)->first();
      
        $currentStock = $pivotData ? $pivotData->pivot->quantity : 0;
        
        $newStock = $currentStock + $stockChange;

        if ($newStock < 0) {
            throw new \Exception('Stok di gudang tidak boleh kurang dari 0. Stok saat ini: ' . $currentStock);
        }

        if ($newStock == 0) {
            $warehouse->products()->detach($productId); 
        } else {
            $warehouse->products()->syncWithoutDetaching([
                $productId => ['quantity' => $newStock]
            ]);
        }
    });

    return redirect()->route('stocks.index')->with('success', 'Transfer stok berhasil diproses.');
    }
}