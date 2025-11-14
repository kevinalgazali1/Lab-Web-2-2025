<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehousesController extends Controller
{
    /**
     * Menampilkan list warehouse.
     */
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(10);
        return view('warehouses.index', compact('warehouses'));
    }

    /**
     * Menampilkan form untuk membuat warehouse baru.
     */
    public function create()
    {
        return view('warehouses.create');
    }

    /**
     * Menyimpan warehouse baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Sesuai constraint NOT NULL
            'location' => 'nullable|string', // Sesuai constraint NULLABLE
        ]);

        Warehouse::create($validatedData);

        return redirect()->route('warehouses.index')
                         ->with('success', 'Gudang berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data warehouse.
     * (Meskipun tidak diminta di PDF, ini adalah praktik yang baik)
     */
    public function show(Warehouse $warehouse)
    {
        return view('warehouses.show', compact('warehouse'));
    }

    /**
     * Menampilkan form untuk mengedit warehouse.
     */
    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    /**
     * Memperbarui data warehouse di database.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        $warehouse->update($validatedData);

        return redirect()->route('warehouses.index')
                         ->with('success', 'Gudang berhasil diperbarui.');
    }

    /**
     * Menghapus data warehouse dari database.
     * (Aksi 'onDelete' akan 'cascade' ke tabel pivot)
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return redirect()->route('warehouses.index')
                         ->with('success', 'Gudang berhasil dihapus.');
    }
}
