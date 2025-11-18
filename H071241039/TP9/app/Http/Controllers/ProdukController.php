<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\DetailProduk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->latest()->get();
        return view('produks.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produks.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:produks,nama',
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'deskripsi' => 'nullable|string',
            'berat' => 'required|numeric|min:0',
            'ukuran' => 'nullable|string|max:255'
        ], [
            'nama.unique' => 'Produk dengan nama ini sudah ada. Silakan gunakan nama yang berbeda.'
        ]);

        $produk = Produk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori_id' => $request->kategori_id
        ]);
        
        DetailProduk::create([
            'produk_id' => $produk->id,
            'deskripsi' => $request->deskripsi,
            'berat' => $request->berat,
            'ukuran' => $request->ukuran
        ]);

        return redirect()->route('produks.index')
            ->with('sukses', 'Produk berhasil dibuat.');
    }

    public function show(Produk $produk)
    {
        $produk->load('kategori', 'detailProduk');
        return view('produks.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        $produk->load('detailProduk');
        return view('produks.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:produks,nama,' . $produk->id,
            'harga' => 'required|numeric|min:0',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'deskripsi' => 'nullable|string',
            'berat' => 'required|numeric|min:0',
            'ukuran' => 'nullable|string|max:255'
        ], [
            'nama.unique' => 'Produk dengan nama ini sudah ada. Silakan gunakan nama yang berbeda.'
        ]);

        $produk->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori_id' => $request->kategori_id
        ]);
        
        $produk->detailProduk->update([
            'deskripsi' => $request->deskripsi,
            'berat' => $request->berat,
            'ukuran' => $request->ukuran
        ]);

        return redirect()->route('produks.index')
            ->with('sukses', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produks.index')
            ->with('sukses', 'Produk berhasil dihapus.');
    }
}