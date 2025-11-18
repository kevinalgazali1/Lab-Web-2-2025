<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Gudang;
use App\Models\StokGudang;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $gudangs = Gudang::all();
        $gudangTerpilih = $request->get('gudang_id');
        
        $stoks = StokGudang::with(['produk', 'gudang'])
            ->when($gudangTerpilih, function($query) use ($gudangTerpilih) {
                return $query->where('gudang_id', $gudangTerpilih);
            })
            ->get();

        return view('stoks.index', compact('stoks', 'gudangs', 'gudangTerpilih'));
    }

    public function transfer()
    {
        $gudangs = Gudang::all();
        $produks = Produk::all();
        return view('stoks.transfer', compact('gudangs', 'produks'));
    }

    public function processTransfer(Request $request)
    {
        $request->validate([
            'gudang_id' => 'required|exists:gudangs,id',
            'produk_id' => 'required|exists:produks,id',
            'kuantitas' => 'required|integer'
        ]);

        $stok = StokGudang::where('gudang_id', $request->gudang_id)
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($stok) {
            $kuantitasBaru = $stok->kuantitas + $request->kuantitas;
            if ($kuantitasBaru < 0) {
                return back()->with('error', 'Stok tidak boleh minus.');
            }
            $stok->update(['kuantitas' => $kuantitasBaru]);
        } else {
            if ($request->kuantitas < 0) {
                return back()->with('error', 'Stok tidak boleh minus.');
            }
            StokGudang::create([
                'gudang_id' => $request->gudang_id,
                'produk_id' => $request->produk_id,
                'kuantitas' => $request->kuantitas
            ]);
        }

        return redirect()->route('stoks.index')
            ->with('sukses', 'Stok berhasil ditransfer.');
    }
}