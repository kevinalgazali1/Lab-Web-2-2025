<?php
namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::latest()->get();
        return view('gudangs.index', compact('gudangs'));
    }

    public function create()
    {
        return view('gudangs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:gudangs,nama',
            'lokasi' => 'nullable|string'
        ], [
            'nama.unique' => 'Gudang dengan nama ini sudah ada. Silakan gunakan nama yang berbeda.'
        ]);

        Gudang::create([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi
        ]);

        return redirect()->route('gudangs.index')
            ->with('sukses', 'Gudang berhasil dibuat.');
    }

    public function edit(Gudang $gudang)
    {
        return view('gudangs.edit', compact('gudang'));
    }

    public function update(Request $request, Gudang $gudang)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:gudangs,nama,' . $gudang->id,
            'lokasi' => 'nullable|string'
        ], [
            'nama.unique' => 'Gudang dengan nama ini sudah ada. Silakan gunakan nama yang berbeda.'
        ]);

        $gudang->update([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi
        ]);

        return redirect()->route('gudangs.index')
            ->with('sukses', 'Gudang berhasil diperbarui.');
    }

    public function destroy(Gudang $gudang)
    {
        $gudang->delete();
        return redirect()->route('gudangs.index')
            ->with('sukses', 'Gudang berhasil dihapus.');
    }
}