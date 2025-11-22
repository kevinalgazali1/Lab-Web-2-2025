<?php
namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    private $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];

    public function index(Request $request)
    {
        $query = Fish::query();

        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }

        $fishes = $query->paginate(10)->withQueryString();

        return view('fishes.index', [
            'fishes' => $fishes,
            'rarities' => $this->rarities
        ]);
    }

    public function create()
    {
        return view('fishes.create', ['rarities' => $this->rarities]);
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:' . implode(',', $this->rarities),
            'base_weight_min' => 'required|decimal:0,2|min:0', // [BENAR]
            'base_weight_max' => 'required|decimal:0,2|min:0|gt:base_weight_min', // [BENAR]
            'sell_price_per_kg' => 'required|integer',
            'catch_probability' => 'required|decimal:0,2|between:0.01,100.00',
            'description' => 'nullable|string',
        ]);

        Fish::create($validated);

        return redirect()->route('fishes.index')->with('success', 'Ikan baru berhasil ditambahkan.');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', ['fish' => $fish]);
    }

    public function edit(Fish $fish)
    {
        return view('fishes.edit', [
            'fish' => $fish, // Data ikan yang sudah ada
            'rarities' => $this->rarities
        ]);
    }

    public function update(Request $request, Fish $fish)
    {
        // Validasi sama seperti create
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:' . implode(',', $this->rarities),
            'base_weight_min' => 'required|decimal:0,2|min:0', // [BENAR]
            'base_weight_max' => 'required|decimal:0,2|min:0|gt:base_weight_min', // [BENAR]
            'sell_price_per_kg' => 'required|integer',
            'catch_probability' => 'required|decimal:0,2|between:0.01,100.00',
            'description' => 'nullable|string',
        ]);

        $fish->update($validated);

        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil diperbarui.');
    }

    
    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil dihapus.');
    }
}