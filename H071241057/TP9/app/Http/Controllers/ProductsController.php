<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Penting untuk Transaction

class ProductsController extends Controller
{
    /**
     * Menampilkan list produk (Nama, Kategori, Harga). [cite: 19]
     */
    public function index()
    {
        // Eager load relasi 'category' agar efisien
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form create produk.
     */
    public function create()
    {
        // Ambil kategori untuk dropdown
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru (beserta detailnya) ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Validasi untuk tabel 'products'
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',

            // Validasi untuk tabel 'product_details'
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        // Gunakan Transaction untuk memastikan data di 2 tabel berhasil disimpan
        DB::beginTransaction();
        try {
            // 1. Simpan ke tabel 'products'
            $product = Product::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'category_id' => $validatedData['category_id'],
            ]);

            // 2. Simpan ke tabel 'product_details' menggunakan relasi
            $product->productDetail()->create([
                'description' => $validatedData['description'],
                'weight' => $validatedData['weight'],
                'size' => $validatedData['size'],
            ]);

            DB::commit(); // Semua sukses, simpan data
        } catch (\Exception $e) {
            DB::rollBack(); // Ada kegagalan, batalkan semua
            return back()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan seluruh data mengenai produk. [cite: 21]
     */
    public function show(Product $product)
    {
        // Load relasi agar data detail dan kategori bisa ditampilkan
        $product->load('category', 'productDetail');
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk (data sebelumnya tampil). [cite: 21]
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        // Pastikan productDetail di-load agar bisa ditampilkan di form
        $product->load('productDetail');

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update data produk (dan detailnya) di database.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update tabel 'products'
            $product->update([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'category_id' => $validatedData['category_id'],
            ]);

            // 2. Update/create tabel 'product_details'
            // 'updateOrCreate' aman jika detailnya belum ada
            $product->productDetail()->updateOrCreate(
                ['product_id' => $product->id], // Kriteria pencarian
                [ // Data untuk di-update atau di-create
                    'description' => $validatedData['description'],
                    'weight' => $validatedData['weight'],
                    'size' => $validatedData['size'],
                ]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     * (Aksi 'onDelete' akan 'cascade' ke product_details & product_warehouse) [cite: 6]
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}
