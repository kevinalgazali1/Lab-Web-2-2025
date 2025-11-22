<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan list kategori.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('category.category', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Sesuai constraint NOT NULL
            'description' => 'nullable|string', // Sesuai constraint NULLABLE
        ]);

        Category::create($validatedData);

        return redirect('/category')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data kategori.
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validatedData);

        return redirect('/category')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus data kategori dari database.
     * (Aksi 'onDelete' akan 'set null' pada produk terkait)
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect('/category')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
