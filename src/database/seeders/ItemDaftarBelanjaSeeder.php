<?php

namespace Database\Seeders;

use App\Models\ItemDaftarBelanja;
use App\Models\MealPlan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ItemDaftarBelanjaSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@mealplanner.test')->first();

        if (! $user) {
            return;
        }

        $mealPlan = MealPlan::with([
            'items.makanan.bahanMakanan',
        ])
            ->where('user_id', $user->id)
            ->where('judul', 'Meal Plan Hari Ini')
            ->whereDate('tanggal_rencana', now()->toDateString())
            ->first();

        if (! $mealPlan) {
            return;
        }

        ItemDaftarBelanja::query()
            ->where('user_id', $user->id)
            ->where('meal_plan_id', $mealPlan->id)
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
                    'user_id' => $user->id,
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
            return;
        }

        ItemDaftarBelanja::insert($groupedItems->values()->all());
    }

    private function groupItems(Collection $items): Collection
    {
        return $items
            ->groupBy(function (array $item): string {
                return strtolower($item['nama_item']) . '|' . strtolower((string) $item['satuan']);
            })
            ->map(function (Collection $group): array {
                $first = $group->first();

                $totalJumlah = $group->sum(function (array $item): float {
                    return (float) ($item['jumlah'] ?? 0);
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