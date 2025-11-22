<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data parent yang sudah kita buat di seeder lain
        $kategoriElektronik = Category::where('name', 'Elektronik')->first();
        $gudangMakassar = Warehouse::where('name', 'Gudang Utama Makassar')->first();
        $gudangGowa = Warehouse::where('name', 'Gudang Cabang Gowa')->first();

        // Hentikan jika data parent tidak ditemukan
        if (!$kategoriElektronik || !$gudangMakassar || !$gudangGowa) {
            $this->command->error('Pastikan CategorySeeder dan WarehouseSeeder sudah dijalankan.');
            return;
        }

        // Gunakan Transaction agar aman
        DB::transaction(function () use ($kategoriElektronik, $gudangMakassar, $gudangGowa) {
            
            // Produk 1: Laptop
            $laptop = Product::create([
                'name' => 'Laptop Gaming ASUS ROG',
                'price' => 15000000.00,
                'category_id' => $kategoriElektronik->id
            ]);

            // Buat detail untuk laptop
            $laptop->detail()->create([
                'description' => 'Laptop gaming dengan spek tinggi.',
                'weight' => 2.50,
                'size' => '15.6 inch'
            ]);

            // Isi stok laptop di kedua gudang (tabel pivot)
            $laptop->warehouses()->attach($gudangMakassar->id, ['quantity' => 20]);
            $laptop->warehouses()->attach($gudangGowa->id, ['quantity' => 10]);


            $mouse = Product::create([
                'name' => 'Mouse Wireless Logitech',
                'price' => 250000.00,
                'category_id' => $kategoriElektronik->id
            ]);

            $mouse->detail()->create([
                'description' => 'Mouse wireless hemat baterai.',
                'weight' => 0.20,
                'size' => 'Medium'
            ]);

            $mouse->warehouses()->attach($gudangMakassar->id, ['quantity' => 150]);

            
            $kursi = Product::create([
                'name' => 'Kursi Kantor',
                'price' => 750000.00,
                'category_id' => null // Contoh produk tanpa kategori
            ]);

            $kursi->detail()->create([
                'description' => 'Kursi ergonomis untuk kerja.',
                'weight' => 15.00,
                'size' => 'Large'
            ]);

            $kursi->warehouses()->attach($gudangGowa->id, ['quantity' => 40]);

        });
    }
}