<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        $electronics = Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic products and gadgets'
        ]);

        $furniture = Category::create([
            'name' => 'Furniture', 
            'description' => 'Home and office furniture'
        ]);

        $warehouse1 = Warehouse::create([
            'name' => 'Gudang Jakarta',
            'location' => 'Jakarta Pusat'
        ]);

        $warehouse2 = Warehouse::create([
            'name' => 'Gudang Surabaya',
            'location' => 'Surabaya'
        ]);

        $laptop = Product::create([
            'name' => 'Laptop ASUS ROG',
            'price' => 15000000,
            'category_id' => $electronics->id
        ]);

        $laptop->detail()->create([
            'description' => 'Gaming laptop with RTX 4060',
            'weight' => 2.5,
            'size' => '15.6 inch'
        ]);

        $chair = Product::create([
            'name' => 'Office Chair',
            'price' => 1200000,
            'category_id' => $furniture->id
        ]);

        $chair->detail()->create([
            'description' => 'Ergonomic office chair',
            'weight' => 8.5,
            'size' => '60x60x120 cm'
        ]);

        $laptop->warehouses()->attach($warehouse1->id, ['quantity' => 10]);
        $laptop->warehouses()->attach($warehouse2->id, ['quantity' => 5]);
        $chair->warehouses()->attach($warehouse1->id, ['quantity' => 20]);
    }
}