<?php

namespace Database\Seeders;

use App\Models\KategoriMakanan;
use Illuminate\Database\Seeder;

class KategoriMakananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Sarapan',
                'deskripsi' => 'Kategori makanan untuk menu sarapan pagi.',
            ],
            [
                'nama' => 'Makan Siang',
                'deskripsi' => 'Kategori makanan untuk menu makan siang.',
            ],
            [
                'nama' => 'Makan Malam',
                'deskripsi' => 'Kategori makanan untuk menu makan malam.',
            ],
            [
                'nama' => 'Snack',
                'deskripsi' => 'Kategori makanan ringan atau camilan.',
            ],
            [
                'nama' => 'Minuman',
                'deskripsi' => 'Kategori minuman pendukung meal plan.',
            ],
        ];

        foreach ($data as $item) {
            KategoriMakanan::updateOrCreate(
                [
                    'nama' => $item['nama'],
                ],
                [
                    'deskripsi' => $item['deskripsi'],
                ]
            );
        }
    }
}