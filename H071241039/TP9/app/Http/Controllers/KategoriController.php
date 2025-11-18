<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('kategoris.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama',
            'deskripsi' => 'nullable|string'
        ], [
            'nama.unique' => 'Kategori dengan nama ini sudah ada. Silakan gunakan nama yang berbeda.'
        ]);

        Kategori::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('kategoris.index')
            ->with('sukses', 'Kategori berhasil dibuat.');
    }

    public function show(Kategori $kategori)
    {
        return view('kategoris.show', compact('kategori'));
    }

    public function edit(Kategori $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string'
        ], [
            'nama.unique' => 'Kategori dengan nama ini sudah ada. Silakan gunakan nama yang berbeda.'
        ]);

        $kategori->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('kategoris.index')
            ->with('sukses', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategoris.index')
            ->with('sukses', 'Kategori berhasil dihapus.');
    }
}