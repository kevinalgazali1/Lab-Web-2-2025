<?php
// database/seeders/KategoriSeeder.php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            [
                'nama' => 'Elektronik',
                'deskripsi' => 'Produk elektronik dan gadget'
            ],
            [
                'nama' => 'Pakaian',
                'deskripsi' => 'Pakaian pria, wanita, dan anak-anak'
            ],
            [
                'nama' => 'Makanan',
                'deskripsi' => 'Makanan dan minuman'
            ],
            [
                'nama' => 'Olahraga',
                'deskripsi' => 'Perlengkapan olahraga'
            ],
            [
                'nama' => 'Buku',
                'deskripsi' => 'Buku dan alat tulis'
            ]
        ];

        foreach ($kategoris as $kategori) {
            // Cek apakah kategori sudah ada
            $existingKategori = Kategori::where('nama', $kategori['nama'])->first();
            
            if (!$existingKategori) {
                Kategori::create($kategori);
                $this->command->info("Kategori '{$kategori['nama']}' berhasil dibuat.");
            } else {
                $this->command->warn("Kategori '{$kategori['nama']}' sudah ada, dilewati.");
            }
        }
    }
}