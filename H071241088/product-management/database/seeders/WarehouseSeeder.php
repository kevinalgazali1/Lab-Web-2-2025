<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::create(['name' => 'Gudang Makassar', 'location' => 'Makassar']);
        Warehouse::create(['name' => 'Gudang Gowa', 'location' => 'Gowa']);
    }
}