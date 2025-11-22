<?php

namespace Database\Seeders;

use App\Models\Fish; // 1. Jangan lupa import Model Fish Anda
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fishes = [
            [
                'name' => 'Lele Dumbo',
                'rarity' => 'Common',
                'base_weight_min' => 0.5,
                'base_weight_max' => 2.0,
                'sell_price_per_kg' => 500,
                'catch_probability' => 75.00,
                'description' => 'Ikan air tawar yang umum ditemukan di rawa-rawa.'
            ],
            [
                'name' => 'Ikan Badut (Nemo)',
                'rarity' => 'Uncommon',
                'base_weight_min' => 0.1,
                'base_weight_max' => 0.3,
                'sell_price_per_kg' => 1200,
                'catch_probability' => 60.00,
                'description' => 'Ikan kecil berwarna oranye yang hidup di anemon.'
            ],
            [
                'name' => 'Tuna Sirip Biru',
                'rarity' => 'Rare',
                'base_weight_min' => 50.0,
                'base_weight_max' => 150.0,
                'sell_price_per_kg' => 3000,
                'catch_probability' => 30.00,
                'description' => 'Ikan cepat dan kuat yang sangat berharga.'
            ],
            [
                'name' => 'Arwana Emas',
                'rarity' => 'Epic',
                'base_weight_min' => 2.0,
                'base_weight_max' => 5.0,
                'sell_price_per_kg' => 10000,
                'catch_probability' => 10.00,
                'description' => 'Dipercaya membawa keberuntungan.'
            ],
            [
                'name' => 'Pari Manta Raksasa',
                'rarity' => 'Legendary',
                'base_weight_min' => 500.0,
                'base_weight_max' => 1000.0,
                'sell_price_per_kg' => 25000,
                'catch_probability' => 2.50,
                'description' => 'Raksasa penyaring yang damai.'
            ],
            [
                'name' => 'Megalodon',
                'rarity' => 'Mythic',
                'base_weight_min' => 40000.0,
                'base_weight_max' => 50000.0,
                'sell_price_per_kg' => 99999,
                'catch_probability' => 0.10,
                'description' => 'Hiu purba yang telah punah... atau belum?'
            ],
            [
                'name' => 'Cumi-cumi Kraken',
                'rarity' => 'Secret',
                'base_weight_min' => 1000.0,
                'base_weight_max' => 3000.0,
                'sell_price_per_kg' => 50000,
                'catch_probability' => 0.01,
                'description' => 'Monster laut dari mitologi.'
            ],
        ];

        foreach ($fishes as $fishData) {
            Fish::create($fishData);
        }
    }
}