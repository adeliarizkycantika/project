<?php

namespace Database\Seeders;

use App\Models\BahanMakanan;
use App\Models\Makanan;
use Illuminate\Database\Seeder;

class BahanMakananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Oatmeal Pisang' => [
                [
                    'nama' => 'Oat',
                    'jumlah' => 50,
                    'satuan' => 'gram',
                ],
                [
                    'nama' => 'Pisang',
                    'jumlah' => 1,
                    'satuan' => 'pcs',
                ],
                [
                    'nama' => 'Susu Rendah Lemak',
                    'jumlah' => 200,
                    'satuan' => 'ml',
                ],
            ],
            'Nasi Merah Ayam Panggang' => [
                [
                    'nama' => 'Nasi Merah',
                    'jumlah' => 150,
                    'satuan' => 'gram',
                ],
                [
                    'nama' => 'Dada Ayam',
                    'jumlah' => 120,
                    'satuan' => 'gram',
                ],
                [
                    'nama' => 'Brokoli',
                    'jumlah' => 80,
                    'satuan' => 'gram',
                ],
                [
                    'nama' => 'Minyak Zaitun',
                    'jumlah' => 1,
                    'satuan' => 'sdm',
                ],
            ],
            'Salad Sayur Telur' => [
                [
                    'nama' => 'Selada',
                    'jumlah' => 80,
                    'satuan' => 'gram',
                ],
                [
                    'nama' => 'Tomat',
                    'jumlah' => 1,
                    'satuan' => 'pcs',
                ],
                [
                    'nama' => 'Telur Rebus',
                    'jumlah' => 2,
                    'satuan' => 'pcs',
                ],
                [
                    'nama' => 'Timun',
                    'jumlah' => 1,
                    'satuan' => 'pcs',
                ],
            ],
            'Greek Yogurt Buah' => [
                [
                    'nama' => 'Greek Yogurt',
                    'jumlah' => 150,
                    'satuan' => 'gram',
                ],
                [
                    'nama' => 'Stroberi',
                    'jumlah' => 50,
                    'satuan' => 'gram',
                ],
                [
                    'nama' => 'Madu',
                    'jumlah' => 1,
                    'satuan' => 'sdm',
                ],
            ],
            'Air Mineral' => [
                [
                    'nama' => 'Air Mineral',
                    'jumlah' => 1,
                    'satuan' => 'botol',
                ],
            ],
        ];

        foreach ($data as $namaMakanan => $bahanList) {
            $makanan = Makanan::where('nama', $namaMakanan)->first();

            if (! $makanan) {
                continue;
            }

            foreach ($bahanList as $bahan) {
                BahanMakanan::updateOrCreate(
                    [
                        'makanan_id' => $makanan->id,
                        'nama' => $bahan['nama'],
                    ],
                    [
                        'jumlah' => $bahan['jumlah'],
                        'satuan' => $bahan['satuan'],
                    ]
                );
            }
        }
    }
}