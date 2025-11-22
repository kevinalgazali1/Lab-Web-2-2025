<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Parent tables first
            CategorySeeder::class,
            WarehouseSeeder::class,
            
            // 2. Child table last (karena butuh data dari atas)
            ProductSeeder::class,
        ]);
    }
}