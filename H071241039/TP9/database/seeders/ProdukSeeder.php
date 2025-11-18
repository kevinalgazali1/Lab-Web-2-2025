<?php
// database/seeders/ProdukSeeder.php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\DetailProduk;
use App\Models\StokGudang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $produks = [
            [
                'nama' => 'Laptop ASUS ROG',
                'harga' => 15000000,
                'kategori' => 'Elektronik',
                'detail' => [
                    'deskripsi' => 'Laptop gaming dengan processor Intel i7 dan GPU RTX 3060',
                    'berat' => 2.5,
                    'ukuran' => '15.6 inch'
                ]
            ],
            [
                'nama' => 'Smartphone Samsung S21',
                'harga' => 8000000,
                'kategori' => 'Elektronik',
                'detail' => [
                    'deskripsi' => 'Smartphone flagship dengan kamera 108MP',
                    'berat' => 0.2,
                    'ukuran' => '6.2 inch'
                ]
            ],
            [
                'nama' => 'Kaos Polo Shirt',
                'harga' => 150000,
                'kategori' => 'Pakaian',
                'detail' => [
                    'deskripsi' => 'Kaos polo cotton combed 30s',
                    'berat' => 0.3,
                    'ukuran' => 'L'
                ]
            ],
            [
                'nama' => 'Sepatu Running',
                'harga' => 500000,
                'kategori' => 'Olahraga',
                'detail' => [
                    'deskripsi' => 'Sepatu lari dengan sol bantalan udara',
                    'berat' => 0.8,
                    'ukuran' => '42'
                ]
            ],
            [
                'nama' => 'Buku Pemrograman Laravel',
                'harga' => 120000,
                'kategori' => 'Buku',
                'detail' => [
                    'deskripsi' => 'Buku panduan lengkap pemrograman Laravel untuk pemula hingga expert',
                    'berat' => 0.5,
                    'ukuran' => 'A5'
                ]
            ]
        ];

        foreach ($produks as $produkData) {
            // Cek apakah produk sudah ada
            $existingProduk = Produk::where('nama', $produkData['nama'])->first();
            
            if ($existingProduk) {
                $this->command->warn("Produk '{$produkData['nama']}' sudah ada, dilewati.");
                continue;
            }

            // Cari kategori
            $kategori = Kategori::where('nama', $produkData['kategori'])->first();
            
            if (!$kategori) {
                $this->command->error("Kategori '{$produkData['kategori']}' tidak ditemukan untuk produk '{$produkData['nama']}'");
                continue;
            }

            try {
                // Buat produk
                $produk = Produk::create([
                    'nama' => $produkData['nama'],
                    'harga' => $produkData['harga'],
                    'kategori_id' => $kategori->id
                ]);

                // Buat detail produk
                DetailProduk::create([
                    'produk_id' => $produk->id,
                    'deskripsi' => $produkData['detail']['deskripsi'],
                    'berat' => $produkData['detail']['berat'],
                    'ukuran' => $produkData['detail']['ukuran']
                ]);

                // Tambahkan stok acak ke gudang
                $gudangs = \App\Models\Gudang::all();
                foreach ($gudangs as $gudang) {
                    StokGudang::create([
                        'produk_id' => $produk->id,
                        'gudang_id' => $gudang->id,
                        'kuantitas' => rand(10, 100)
                    ]);
                }

                $this->command->info("Produk '{$produkData['nama']}' berhasil dibuat dengan stok di {$gudangs->count()} gudang.");

            } catch (\Exception $e) {
                $this->command->error("Gagal membuat produk '{$produkData['nama']}': " . $e->getMessage());
            }
        }
    }
}