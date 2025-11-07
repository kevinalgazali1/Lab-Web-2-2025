<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    public function index(Request $request)
    {
        $query = Fish::query();

        // Search by name (opsional)
        if ($request->filled('search')) {
            $q = $request->get('search');
            $query->where('name', 'LIKE', "%{$q}%");
        }

        // Filter rarity (scope)
        $query->rarity($request->get('rarity'));

        // Sort (opsional): name / sell_price_per_kg / catch_probability
        if ($request->filled('sort_by') && in_array($request->get('sort_by'), ['name','sell_price_per_kg','catch_probability'])) {
            $direction = $request->get('sort_dir') === 'asc' ? 'asc' : 'desc';
            $query->orderBy($request->get('sort_by'), $direction);
        } else {
            $query->latest();
        }

        $fishes = $query->paginate(10)->withQueryString();
        $rarities = ['Semua Rarity'=>'Semua Rarity','Common'=>'Common','Uncommon'=>'Uncommon','Rare'=>'Rare','Epic'=>'Epic','Legendary'=>'Legendary','Mythic'=>'Mythic','Secret'=>'Secret'];

        return view('fishes.index', compact('fishes','rarities'));
    }

    public function create()
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.create', compact('rarities'));
    }

    public function store(Request $request)
    {
        $messages = [
        'base_weight_min.min' => 'Berat minimum ikan tidak boleh kurang dari 0.1 kg.',
        'base_weight_min.max' => 'Berat minimum ikan tidak boleh lebih dari 10.000 kg.',
        'base_weight_max.min' => 'Berat maksimum ikan tidak boleh kurang dari 0.1 kg.',
        'base_weight_max.max' => 'Berat maksimum ikan tidak boleh lebih dari 10.000 kg.',
        'base_weight_max.gte' => 'Berat maksimum harus lebih besar atau sama dengan berat minimum.',
        'catch_probability.min' => 'Probabilitas harus minimal 0.01%.',
        'catch_probability.max' => 'Probabilitas tidak boleh lebih dari 100%.',
    ];
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            // ✅ Berat ikan: 0.1 - 100 kg
            'base_weight_min' => 'required|numeric|min:0.1|max:10000',
            'base_weight_max' => 'required|numeric|min:0.1|max:10000|gte:base_weight_min',
            // ✅ Harga tidak boleh negatif
            'sell_price_per_kg' => 'required|integer|min:1',
            // ✅ Probabilitas tertangkap: 0.01% - 100%
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string'
        ]);

        Fish::create($data);

        return redirect()->route('fishes.index')->with('success','Fish created successfully!');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    public function edit(Fish $fish)
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.edit', compact('fish','rarities'));
    }

    public function update(Request $request, Fish $fish)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.1|max:10000',
            'base_weight_max' => 'required|numeric|min:0.1|max:10000|gte:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:1',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string'
        ]);

        $fish->update($data);

        return redirect()->route('fishes.index')->with('success','Fish updated successfully!');
    }

    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index')->with('success','Fish deleted successfully!');
    }
}