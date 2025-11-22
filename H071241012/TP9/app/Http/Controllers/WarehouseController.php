<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::latest()->get(); 
        return view('warehouses.index', compact('warehouses'));
    }

    public function edit(Warehouse $warehouse)
    {
    return view('warehouses.edit', compact('warehouse'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:warehouses,name',
            'location' => 'nullable|string',
        ]);

        Warehouse::create($validated);
        
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil ditambahkan.');
    }

public function update(Request $request, Warehouse $warehouse)
{
    $validated = $request->validate([
        'name' => 'required|max:255|unique:warehouses,name,' . $warehouse->id,
        'location' => 'nullable|string',
    ]);

    $warehouse->update($validated);
    
    return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil diperbarui.');
}

public function destroy(Warehouse $warehouse)
{
    // Jika warehouse punya relasi many-to-many ke product, putuskan dulu
    $warehouse->products()->detach();

    // Hapus warehouse
    $warehouse->delete();

    return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil dihapus.');
}
}