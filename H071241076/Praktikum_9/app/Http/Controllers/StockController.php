<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $stockQuery = DB::table('product_warehouse')
            ->join('products', 'product_warehouse.product_id', '=', 'products.id')
            ->join('warehouses', 'product_warehouse.warehouse_id', '=', 'warehouses.id')
            ->select(
                'warehouses.name as warehouse_name',
                'products.name as product_name',
                DB::raw('SUM(product_warehouse.quantity) as total_quantity') 
            )
            ->groupBy('warehouses.name', 'products.name');

        $warehouses = Warehouse::all();

        if ($request->filled('warehouse_id')) {
            $stockQuery->where('product_warehouse.warehouse_id', $request->warehouse_id);
        }
        
        $stocks = $stockQuery->paginate(10);
                             
        return view('stocks.index', compact('stocks', 'warehouses'));
    }

    /**
     * Menampilkan form untuk transfer (tambah/kurang) stok.
     */
    public function create()
    {
        $warehouses = Warehouse::all();
        
        $products = Product::all();

        return view('stocks.create', compact('warehouses', 'products'));
    }

    /**
     * Memproses form transfer stok (masuk/keluar).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|not_in:0',
        ]);

        $warehouseId = $validated['warehouse_id'];
        $productId = $validated['product_id'];
        $transferQuantity = (int) $validated['quantity'];

        try {
            $stock = DB::table('product_warehouse')
                ->where('warehouse_id', $warehouseId)
                ->where('product_id', $productId)
                ->lockForUpdate() 
                ->first();

            $currentQuantity = $stock->quantity ?? 0; // Jika $stock null, stok 0

            $newQuantity = $currentQuantity + $transferQuantity;

            if ($newQuantity < 0) {
                return redirect()->back()
                    ->with('error', 'Stok tidak mencukupi! Kuantitas saat ini: ' . $currentQuantity)
                    ->withInput();
            }

            DB::table('product_warehouse')->updateOrInsert(
                [ 
                    'warehouse_id' => $warehouseId,
                    'product_id' => $productId,
                ],
                [ 
                    'quantity' => $newQuantity,
                ]
            );

            return redirect()->route('stocks.index')
                             ->with('success', 'Transfer stok berhasil diproses!');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memproses stok: ' . $e->getMessage())
                             ->withInput();
        }
    }
}