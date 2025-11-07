<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Fish extends Model
{
    protected $table = 'fishes';
    protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description'
    ];

    protected $casts = [
        'base_weight_min' => 'decimal:2',
        'base_weight_max' => 'decimal:2',
        'catch_probability' => 'decimal:2',
        'sell_price_per_kg' => 'integer'
    ];

    // Accessor: format harga (Coins)
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->sell_price_per_kg, 0, ',', '.').' Coins/kg';
    }

    // Accessor: rentang berat (kg)
    public function getWeightRangeAttribute(): string
    {
        return number_format($this->base_weight_min, 2).' - '.number_format($this->base_weight_max, 2).' kg';
    }

    // Scope: filter rarity
    public function scopeRarity(Builder $query, ?string $rarity)
    {
        if ($rarity && in_array($rarity, ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'])) {
            $query->where('rarity', $rarity);
        }
        return $query;
    }

    // Mutator/validation not required here; validation handled in controller
}