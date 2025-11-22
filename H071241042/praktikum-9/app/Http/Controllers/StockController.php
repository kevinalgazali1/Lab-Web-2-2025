<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::all();
        $selectedWarehouse = $request->get('warehouse_id');
        
        $query = Product::with(['warehouses' => function($query) use ($selectedWarehouse) {
            if ($selectedWarehouse) {
                $query->where('warehouse_id', $selectedWarehouse);
            }
        }]);

        $products = $query->get();

        return view('stock.index', compact('products', 'warehouses', 'selectedWarehouse'));
    }

    public function transferForm()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return view('stock.transfer', compact('products', 'warehouses'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer'
        ]);

        $product = Product::find($request->product_id);
        $warehouse = Warehouse::find($request->warehouse_id);
        $quantity = $request->quantity;

        $currentStock = $product->warehouses()
            ->where('warehouse_id', $warehouse->id)
            ->first();

        $currentQuantity = $currentStock ? $currentStock->pivot->quantity : 0;
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity < 0) {
            return redirect()->back()
                ->with('error', 'Stock cannot be negative. Current stock: ' . $currentQuantity)
                ->withInput();
        }

        $product->warehouses()->syncWithoutDetaching([
            $warehouse->id => ['quantity' => $newQuantity]
        ]);

        $action = $quantity >= 0 ? 'added to' : 'removed from';
        return redirect()->route('stock.index')
            ->with('success', abs($quantity) . " stock {$action} {$warehouse->name} for {$product->name}");
    }
}