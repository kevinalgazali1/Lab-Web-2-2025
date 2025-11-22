<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0.01',
            // Atribut ProductDetail 
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.01',
            'size' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::create($request->only('name', 'price', 'category_id'));
            $product->detail()->create($request->only('description', 'weight', 'size'));
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('detail'); 
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {

        DB::transaction(function () use ($request, $product) {
            $product->update($request->only('name', 'price', 'category_id'));
            $product->detail()->updateOrCreate(
                ['product_id' => $product->id],
                $request->only('description', 'weight', 'size')
            );
        });

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $product->warehouses()->detach(); 
            $product->detail()->delete();
            
            $product->delete();
        });
        
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'detail', 'warehouses']);
        return view('products.show', compact('product'));
    }
}