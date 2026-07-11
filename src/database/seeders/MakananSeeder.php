<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MakananSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('makanan')) {
            return;
        }

        $kategoriTable = $this->getKategoriTable();

        if (! $kategoriTable) {
            return;
        }

        $kategoriId = $this->getOrCreateKategoriId($kategoriTable);

        if (! $kategoriId) {
            return;
        }

        $now = now();

        $data = [
            [
                'nama' => 'Nasi Merah Ayam Panggang',
                'kategori_makanan_id' => $kategoriId,
                'deskripsi' => 'Menu seimbang dengan sumber karbohidrat kompleks dan protein rendah lemak.',
                'kalori' => 430,
                'protein' => 32,
                'karbohidrat' => 48,
                'lemak' => 10,
                'is_recommended' => true,
                'is_public' => true,
                'recommended_note' => 'Cocok untuk makan siang karena mengandung karbohidrat kompleks dan protein yang cukup.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Oatmeal Pisang dan Susu Rendah Lemak',
                'kategori_makanan_id' => $kategoriId,
                'deskripsi' => 'Menu sarapan praktis dengan serat tinggi dan energi yang stabil.',
                'kalori' => 320,
                'protein' => 12,
                'karbohidrat' => 55,
                'lemak' => 7,
                'is_recommended' => true,
                'is_public' => true,
                'recommended_note' => 'Cocok untuk sarapan karena tinggi serat dan membantu kenyang lebih lama.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Telur Rebus dan Roti Gandum',
                'kategori_makanan_id' => $kategoriId,
                'deskripsi' => 'Kombinasi protein dan karbohidrat ringan untuk menu pagi atau cemilan sehat.',
                'kalori' => 280,
                'protein' => 18,
                'karbohidrat' => 30,
                'lemak' => 9,
                'is_recommended' => true,
                'is_public' => true,
                'recommended_note' => 'Pilihan ringan untuk sarapan tinggi protein dengan kalori yang masih terkendali.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Sup Sayur Tahu',
                'kategori_makanan_id' => $kategoriId,
                'deskripsi' => 'Menu rendah kalori dengan sayuran dan protein nabati.',
                'kalori' => 210,
                'protein' => 14,
                'karbohidrat' => 20,
                'lemak' => 8,
                'is_recommended' => true,
                'is_public' => true,
                'recommended_note' => 'Cocok untuk makan malam ringan karena rendah kalori dan tetap mengandung protein.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Greek Yogurt Buah',
                'kategori_makanan_id' => $kategoriId,
                'deskripsi' => 'Cemilan sehat dengan protein, serat, dan rasa segar dari buah.',
                'kalori' => 190,
                'protein' => 13,
                'karbohidrat' => 24,
                'lemak' => 5,
                'is_recommended' => true,
                'is_public' => true,
                'recommended_note' => 'Cocok sebagai cemilan sehat di antara waktu makan utama.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Ikan Kukus Sayur Hijau',
                'kategori_makanan_id' => $kategoriId,
                'deskripsi' => 'Menu tinggi protein dengan lemak rendah dan tambahan sayuran hijau.',
                'kalori' => 360,
                'protein' => 35,
                'karbohidrat' => 22,
                'lemak' => 12,
                'is_recommended' => true,
                'is_public' => true,
                'recommended_note' => 'Direkomendasikan untuk makan malam karena tinggi protein dan tidak terlalu berat.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($data as $item) {
            DB::table('makanan')->updateOrInsert(
                [
                    'nama' => $item['nama'],
                ],
                $this->filterExistingColumns('makanan', $item)
            );
        }
    }

    private function getKategoriTable(): ?string
    {
        if (Schema::hasTable('kategori_makanan')) {
            return 'kategori_makanan';
        }

        if (Schema::hasTable('kategori_makanans')) {
            return 'kategori_makanans';
        }

        return null;
    }

    private function getOrCreateKategoriId(string $kategoriTable): ?int
    {
        $kategori = DB::table($kategoriTable)->first();

        if ($kategori) {
            return (int) $kategori->id;
        }

        $data = [
            'nama' => 'Menu Sehat',
            'deskripsi' => 'Kategori untuk menu makanan sehat.',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $insertData = $this->filterExistingColumns($kategoriTable, $data);

        if (! array_key_exists('nama', $insertData)) {
            return null;
        }

        return (int) DB::table($kategoriTable)->insertGetId($insertData);
    }

    private function filterExistingColumns(string $table, array $data): array
    {
        $filtered = [];

        foreach ($data as $column => $value) {
            if (Schema::hasColumn($table, $column)) {
                $filtered[$column] = $value;
            }
        }

        return $filtered;
    }
}