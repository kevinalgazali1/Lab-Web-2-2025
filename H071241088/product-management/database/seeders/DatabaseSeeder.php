<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class, // Parent
            WarehouseSeeder::class, // Parent
            ProductSeeder::class, // Child (bergantung pada Category dan Warehouse)
        ]);
    }
}