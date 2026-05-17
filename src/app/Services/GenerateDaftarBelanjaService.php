<?php

namespace App\Services;

use App\Models\ItemDaftarBelanja;
use App\Models\MealPlan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GenerateDaftarBelanjaService
{
    public function generate(MealPlan $mealPlan): int
    {
        return DB::transaction(function () use ($mealPlan): int {
            $mealPlan->load([
                'items.makanan.bahanMakanan',
                'user',
            ]);

            ItemDaftarBelanja::query()
                ->where('meal_plan_id', $mealPlan->id)
                ->where('user_id', $mealPlan->user_id)
                ->delete();

            $items = collect();

            foreach ($mealPlan->items as $mealPlanItem) {
                $makanan = $mealPlanItem->makanan;

                if (! $makanan) {
                    continue;
                }

                foreach ($makanan->bahanMakanan as $bahanMakanan) {
                    $jumlah = $bahanMakanan->jumlah !== null
                        ? (float) $bahanMakanan->jumlah * (int) $mealPlanItem->porsi
                        : null;

                    $items->push([
                        'user_id' => $mealPlan->user_id,
                        'meal_plan_id' => $mealPlan->id,
                        'bahan_makanan_id' => $bahanMakanan->id,
                        'nama_item' => $bahanMakanan->nama,
                        'jumlah' => $jumlah,
                        'satuan' => $bahanMakanan->satuan,
                        'sudah_dibeli' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $groupedItems = $this->groupItems($items);

            if ($groupedItems->isEmpty()) {
                return 0;
            }

            ItemDaftarBelanja::insert($groupedItems->values()->all());

            return $groupedItems->count();
        });
    }

    private function groupItems(Collection $items): Collection
    {
        return $items
            ->groupBy(function (array $item): string {
                return strtolower($item['nama_item']) . '|' . strtolower((string) $item['satuan']);
            })
            ->map(function (Collection $group) {
                $first = $group->first();

                $totalJumlah = $group->sum(function (array $item) {
                    return $item['jumlah'] ?? 0;
                });

                return [
                    'user_id' => $first['user_id'],
                    'meal_plan_id' => $first['meal_plan_id'],
                    'bahan_makanan_id' => $first['bahan_makanan_id'],
                    'nama_item' => $first['nama_item'],
                    'jumlah' => $totalJumlah > 0 ? $totalJumlah : null,
                    'satuan' => $first['satuan'],
                    'sudah_dibeli' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });
    }
}