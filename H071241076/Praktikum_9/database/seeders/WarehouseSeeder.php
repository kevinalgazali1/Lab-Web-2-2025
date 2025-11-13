<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouse::create([
            'name' => 'Gudang Utama Makassar',
            'location' => 'Jl. Perintis Kemerdekaan KM. 10'
        ]);

        Warehouse::create([
            'name' => 'Gudang Cabang Gowa',
            'location' => 'Jl. Poros Malino'
        ]);
    }
}