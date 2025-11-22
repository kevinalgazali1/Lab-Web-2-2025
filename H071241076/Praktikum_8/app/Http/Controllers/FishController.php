<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{

    public function index(Request $request)
    {

        $rarities = [
            'Common',
            'Uncommon',
            'Rare',
            'Epic',
            'Legendary',
            'Mythic',
            'Secret'
        ];

        $query = Fish::query();

        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }

        $fishes = $query->latest()->paginate(10);

        return view('fishes.index', compact('fishes', 'rarities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rarities = [
            'Common',
            'Uncommon',
            'Rare',
            'Epic',
            'Legendary',
            'Mythic',
            'Secret'
        ];

        return view('fishes.create', compact('rarities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',

            'base_weight_min' => 'required|numeric|min:0.01',

            'base_weight_max' => 'required|numeric|gte:base_weight_min',

            'sell_price_per_kg' => 'required|integer|min:1',

            'catch_probability' => 'required|numeric|min:0.01|max:100.00',

            'description' => 'nullable|string',
        ], [
            'base_weight_max.gte' => 'Berat maksimum harus lebih besar atau sama dengan berat minimum.',
        ]);

        Fish::create($validatedData);

        return redirect()->route('fishes.index')
            ->with('success', 'Ikan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fish $fish)
    {

        $rarities = [
            'Common',
            'Uncommon',
            'Rare',
            'Epic',
            'Legendary',
            'Mythic',
            'Secret'
        ];

        return view('fishes.edit', compact('fish', 'rarities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fish $fish) // Gunakan Route Model Binding
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|gte:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:1',
            'catch_probability' => 'required|numeric|min:0.01|max:100.00',
            'description' => 'nullable|string',
        ], [
            'base_weight_max.gte' => 'Berat maksimum harus lebih besar atau sama dengan berat minimum.',
        ]);

        $fish->update($validatedData);

        return redirect()->route('fishes.index')
            ->with('success', 'Data ikan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fish $fish) 
    {
        $fish->delete();

        return redirect()->route('fishes.index')
            ->with('success', 'Ikan berhasil dihapus!');
    }
}
