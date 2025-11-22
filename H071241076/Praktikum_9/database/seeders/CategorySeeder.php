<?php

namespace Database\Seeders;

use App\Models\Category; // Import model
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Elektronik',
            'description' => 'Semua barang elektronik konsumen.'
        ]);

        Category::create([
            'name' => 'Perabotan',
            'description' => 'Perabotan rumah tangga.'
        ]);
        
        Category::create([
            'name' => 'Alat Tulis Kantor',
            'description' => 'Kebutuhan kantor dan sekolah.'
        ]);
    }
}