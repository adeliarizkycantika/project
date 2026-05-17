<?php

namespace Database\Seeders;

use App\Models\KategoriMakanan;
use App\Models\Makanan;
use Illuminate\Database\Seeder;

class MakananSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriSarapan = KategoriMakanan::where('nama', 'Sarapan')->first();
        $kategoriMakanSiang = KategoriMakanan::where('nama', 'Makan Siang')->first();
        $kategoriMakanMalam = KategoriMakanan::where('nama', 'Makan Malam')->first();
        $kategoriSnack = KategoriMakanan::where('nama', 'Snack')->first();
        $kategoriMinuman = KategoriMakanan::where('nama', 'Minuman')->first();

        if (
            ! $kategoriSarapan ||
            ! $kategoriMakanSiang ||
            ! $kategoriMakanMalam ||
            ! $kategoriSnack ||
            ! $kategoriMinuman
        ) {
            return;
        }

        $data = [
            [
                'kategori_makanan_id' => $kategoriSarapan->id,
                'nama' => 'Oatmeal Pisang',
                'deskripsi' => 'Menu sarapan sehat dengan oat, pisang, dan susu rendah lemak.',
                'kalori' => 250,
                'protein' => 7,
                'karbohidrat' => 60,
                'lemak' => 3,
                'gambar' => null,
            ],
            [
                'kategori_makanan_id' => $kategoriMakanSiang->id,
                'nama' => 'Nasi Merah Ayam Panggang',
                'deskripsi' => 'Menu makan siang tinggi protein dengan nasi merah dan ayam panggang.',
                'kalori' => 650,
                'protein' => 38,
                'karbohidrat' => 70,
                'lemak' => 18,
                'gambar' => null,
            ],
            [
                'kategori_makanan_id' => $kategoriMakanMalam->id,
                'nama' => 'Salad Sayur Telur',
                'deskripsi' => 'Menu makan malam ringan dengan sayur segar dan telur rebus.',
                'kalori' => 380,
                'protein' => 18,
                'karbohidrat' => 28,
                'lemak' => 20,
                'gambar' => null,
            ],
            [
                'kategori_makanan_id' => $kategoriSnack->id,
                'nama' => 'Greek Yogurt Buah',
                'deskripsi' => 'Snack sehat dengan yogurt dan buah.',
                'kalori' => 180,
                'protein' => 12,
                'karbohidrat' => 25,
                'lemak' => 4,
                'gambar' => null,
            ],
            [
                'kategori_makanan_id' => $kategoriMinuman->id,
                'nama' => 'Air Mineral',
                'deskripsi' => 'Minuman bebas kalori untuk kebutuhan cairan harian.',
                'kalori' => 0,
                'protein' => 0,
                'karbohidrat' => 0,
                'lemak' => 0,
                'gambar' => null,
            ],
        ];

        foreach ($data as $item) {
            Makanan::updateOrCreate(
                [
                    'nama' => $item['nama'],
                ],
                $item
            );
        }
    }
}