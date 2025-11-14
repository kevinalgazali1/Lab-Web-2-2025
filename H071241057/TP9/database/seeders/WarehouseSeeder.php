<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Elektronik',
            'description' => 'Semua jenis barang elektronik.'
        ]);

        Category::create([
            'name' => 'Pakaian',
            'description' => 'Pakaian pria, wanita, dan anak-anak.'
        ]);

        Category::create([
            'name' => 'Perabotan Rumah Tangga',
            'description' => 'Meja, kursi, lemari, dan dekorasi.'
        ]);

        Category::create([
            'name' => 'Alat Tulis Kantor',
            'description' => 'Kertas, pena, dan perlengkapan kantor lainnya.'
        ]);

        Warehouse::create([
            'name' => 'Gudang Utama Makassar',
            'location' => 'Jl. Perintis Kemerdekaan KM. 10, Makassar'
        ]);

        Warehouse::create([
            'name' => 'Gudang Cabang Gowa',
            'location' => 'Jl. Poros Malino No. 123, Gowa'
        ]);

        Warehouse::create([
            'name' => 'Gudang Transit Maros',
            'location' => 'Kawasan Pergudangan Bandara, Maros'
        ]);

        $elektronik = Category::where('name', 'Elektronik')->first();
        $pakaian = Category::where('name', 'Pakaian')->first();
        $perabotan = Category::where('name', 'Perabotan Rumah Tangga')->first();

        // Gunakan transaction agar aman, sama seperti di controller Anda
        FacadesDB::transaction(function () use ($elektronik, $pakaian, $perabotan) {

            // --- Produk 1 ---
            $laptop = Product::create([
                'name' => 'Laptop ASUS ROG Strix G15',
                'price' => 25000000.00,
                'category_id' => $elektronik ? $elektronik->id : null
            ]);
            // Langsung buat detailnya menggunakan relasi
            $laptop->productDetail()->create([
                'description' => 'Laptop gaming high-end dengan RTX 4060.',
                'weight' => 2.50,
                'size' => '15.6 inch'
            ]);

            // --- Produk 2 ---
            $kaos = Product::create([
                'name' => 'Kaos Polos Cotton Combed 30s',
                'price' => 85000.00,
                'category_id' => $pakaian ? $pakaian->id : null
            ]);
            $kaos->productDetail()->create([
                'description' => 'Kaos polos warna hitam, bahan adem dan nyaman.',
                'weight' => 0.20,
                'size' => 'L (Large)'
            ]);

            // --- Produk 3 ---
            $meja = Product::create([
                'name' => 'Meja Kerja Minimalis',
                'price' => 1200000.00,
                'category_id' => $perabotan ? $perabotan->id : null
            ]);
            $meja->productDetail()->create([
                'description' => 'Meja kerja kayu solid dengan kaki besi hollow.',
                'weight' => 15.00,
                'size' => '120x60x75 cm'
            ]);

            // --- Produk 4 (Contoh tanpa kategori) ---
            $buku = Product::create([
                'name' => 'Buku Tulis Sinar Dunia',
                'price' => 5000.00,
                'category_id' => null // Contoh produk tanpa kategori
            ]);
            $buku->productDetail()->create([
                'description' => 'Buku tulis 50 lembar bergaris.',
                'weight' => 0.15,
                'size' => 'B5'
            ]);
        });
    }
}
