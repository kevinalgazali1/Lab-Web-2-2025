<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Elektronik', 'description' => 'Produk berbasis listrik dan digital.']);
        Category::create(['name' => 'Peralatan Dapur', 'description' => 'Produk untuk kebutuhan memasak.']);
    }
}