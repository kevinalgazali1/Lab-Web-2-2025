<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    /**
     * Menampilkan daftar semua ikan dengan pagination + filter rarity
     */
    public function index(Request $request)
    {
        $query = Fish::query(); //query builder dari fish

        // Filter berdasarkan rarity
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }

        // Search by name (opsional)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $fishes = $query->paginate(10)->withQueryString();
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];

        return view('fishes.index', compact('fishes', 'rarities'));
    }

    /**
     * Form tambah data ikan
     */
    public function create()
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.create', compact('rarities'));
    }

    /**
     * Simpan data ikan baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100.00',
            'description' => 'nullable|string'
        ]);

        Fish::create($validated);
        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail ikan
     */
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    /**
     * Form edit data ikan
     */
    public function edit(Fish $fish)
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.edit', compact('fish', 'rarities'));
    }

    /**
     * Update data ikan di database
     */
    public function update(Request $request, Fish $fish)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100.00',
            'description' => 'nullable|string'
        ]);

        $fish->update($validated);
        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil diperbarui!');
    }

    /**
     * Hapus data ikan
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil dihapus!');
    }
}
