<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryElektronik = Category::where('name', 'Elektronik')->first();
        $warehouseMakassar = Warehouse::where('name', 'Gudang Makassar')->first();

        if (!$categoryElektronik || !$warehouseMakassar) {
             $this->command->error('Category atau Warehouse tidak ditemukan. Jalankan Seeder Parent dahulu.');
             return;
        }

        DB::transaction(function () use ($categoryElektronik, $warehouseMakassar) {
            $product = Product::create([
                'name' => 'Laptop ASUS ROG',
                'price' => 15000000.00,
                'category_id' => $categoryElektronik->id
            ]);

            $product->detail()->create([
                'description' => 'Laptop gaming bertenaga tinggi.',
                'weight' => 2.50,
                'size' => '15 inch'
            ]);

            $product->warehouses()->attach($warehouseMakassar->id, ['quantity' => 50]);
        });
    }
}