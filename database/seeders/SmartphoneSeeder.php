<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Smartphone;

class SmartphoneSeeder extends Seeder
{
    public function run(): void
    {
        $smartphones = [
            [
                'nama_produk' => 'iPhone 15 Pro Max',
                'merek' => 'Apple',
                'model' => 'A3108',
                'spesifikasi' => 'Chip A17 Pro, Kamera 48MP',
                'harga_beli' => 17000000,
                'harga_jual' => 21000000,
                'stok' => 15,
                'warna' => 'Natural Titanium',
                'kapasitas_storage' => '256GB',
                'ram' => '8GB',
                'kondisi' => 'baru',
                'status' => 'tersedia',
            ],
            [
                'nama_produk' => 'Samsung Galaxy S24 Ultra',
                'merek' => 'Samsung',
                'model' => 'SM-S928B',
                'spesifikasi' => 'Snapdragon 8 Gen 3, Kamera 200MP',
                'harga_beli' => 14000000,
                'harga_jual' => 18500000,
                'stok' => 20,
                'warna' => 'Titanium Black',
                'kapasitas_storage' => '512GB',
                'ram' => '12GB',
                'kondisi' => 'baru',
                'status' => 'tersedia',
            ],
        ];

        foreach ($smartphones as $item) {
            Smartphone::updateOrCreate(
                ['nama_produk' => $item['nama_produk']],
                $item
            );
        }
    }
}