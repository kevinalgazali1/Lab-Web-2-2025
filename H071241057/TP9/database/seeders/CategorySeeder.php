<?php

namespace Database\Seeders;

use App\Http\Controllers\CategoryController;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Test User',
            'description' => 'test@example.com',
        ]);
        Category::create([
            'name' => 'makanan',
            'description' => 'ayam',
        ]);
        Category::create([
            'name' => 'Tech',
            'description' => 'testsjnsjns',
        ]);
    }
}
