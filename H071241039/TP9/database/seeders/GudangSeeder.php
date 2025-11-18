<?php
// database/seeders/GudangSeeder.php

namespace Database\Seeders;

use App\Models\Gudang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GudangSeeder extends Seeder
{
    public function run()
    {
        $gudangs = [
            [
                'nama' => 'Gudang Pusat',
                'lokasi' => 'Jakarta Pusat'
            ],
            [
                'nama' => 'Gudang Barat',
                'lokasi' => 'Tangerang'
            ],
            [
                'nama' => 'Gudang Timur',
                'lokasi' => 'Bekasi'
            ],
            [
                'nama' => 'Gudang Selatan',
                'lokasi' => 'Depok'
            ]
        ];

        foreach ($gudangs as $gudang) {
            // Cek apakah gudang sudah ada
            $existingGudang = Gudang::where('nama', $gudang['nama'])->first();
            
            if (!$existingGudang) {
                Gudang::create($gudang);
                $this->command->info("Gudang '{$gudang['nama']}' berhasil dibuat.");
            } else {
                $this->command->warn("Gudang '{$gudang['nama']}' sudah ada, dilewati.");
            }
        }
    }
}