<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rarity = $request->get('rarity');

        $query = Fish::query();

        if ($rarity) {
            $query->where('rarity', $rarity);
        }

        $fishes = $query->paginate(10);

        return view('fishes.index', compact('fishes', 'rarity'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.create', compact('rarities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'rarity' => 'required',
            'base_weight_min' => 'required|numeric',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer',
            'catch_probability' => 'required|numeric|between:0.01,100',
        ]);

        Fish::create($request->all());

        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil ditambahkan!');
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
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.edit', compact('fish', 'rarities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fish $fish)
    {
        $request->validate([
            'name' => 'required|max:100',
            'rarity' => 'required',
            'base_weight_min' => 'required|numeric',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer',
            'catch_probability' => 'required|numeric|between:0.01,100',
        ]);

        $fish->update($request->all());

        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil dihapus!');
    }
}
