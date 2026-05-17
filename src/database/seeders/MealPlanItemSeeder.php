<?php

namespace Database\Seeders;

use App\Models\Makanan;
use App\Models\MealPlan;
use App\Models\MealPlanItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class MealPlanItemSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@mealplanner.test')->first();

        if (! $user) {
            return;
        }

        $mealPlanHariIni = MealPlan::where('user_id', $user->id)
            ->where('judul', 'Meal Plan Hari Ini')
            ->whereDate('tanggal_rencana', now()->toDateString())
            ->first();

        $mealPlanBesok = MealPlan::where('user_id', $user->id)
            ->where('judul', 'Meal Plan Besok')
            ->whereDate('tanggal_rencana', now()->addDay()->toDateString())
            ->first();

        if (! $mealPlanHariIni || ! $mealPlanBesok) {
            return;
        }

        $oatmeal = Makanan::where('nama', 'Oatmeal Pisang')->first();
        $ayam = Makanan::where('nama', 'Nasi Merah Ayam Panggang')->first();
        $salad = Makanan::where('nama', 'Salad Sayur Telur')->first();
        $yogurt = Makanan::where('nama', 'Greek Yogurt Buah')->first();
        $air = Makanan::where('nama', 'Air Mineral')->first();

        if (! $oatmeal || ! $ayam || ! $salad || ! $yogurt || ! $air) {
            return;
        }

        $data = [
            [
                'meal_plan_id' => $mealPlanHariIni->id,
                'makanan_id' => $oatmeal->id,
                'waktu_makan' => 'sarapan',
                'porsi' => 1,
                'sudah_dikonsumsi' => true,
                'dikonsumsi_pada' => now(),
                'catatan' => 'Sarapan pagi sebelum aktivitas.',
            ],
            [
                'meal_plan_id' => $mealPlanHariIni->id,
                'makanan_id' => $ayam->id,
                'waktu_makan' => 'makan_siang',
                'porsi' => 1,
                'sudah_dikonsumsi' => false,
                'dikonsumsi_pada' => null,
                'catatan' => 'Menu makan siang tinggi protein.',
            ],
            [
                'meal_plan_id' => $mealPlanHariIni->id,
                'makanan_id' => $yogurt->id,
                'waktu_makan' => 'snack',
                'porsi' => 1,
                'sudah_dikonsumsi' => false,
                'dikonsumsi_pada' => null,
                'catatan' => 'Snack sore.',
            ],
            [
                'meal_plan_id' => $mealPlanHariIni->id,
                'makanan_id' => $salad->id,
                'waktu_makan' => 'makan_malam',
                'porsi' => 1,
                'sudah_dikonsumsi' => false,
                'dikonsumsi_pada' => null,
                'catatan' => 'Makan malam ringan.',
            ],
            [
                'meal_plan_id' => $mealPlanBesok->id,
                'makanan_id' => $oatmeal->id,
                'waktu_makan' => 'sarapan',
                'porsi' => 1,
                'sudah_dikonsumsi' => false,
                'dikonsumsi_pada' => null,
                'catatan' => 'Sarapan untuk besok.',
            ],
            [
                'meal_plan_id' => $mealPlanBesok->id,
                'makanan_id' => $air->id,
                'waktu_makan' => 'snack',
                'porsi' => 2,
                'sudah_dikonsumsi' => false,
                'dikonsumsi_pada' => null,
                'catatan' => 'Minum air cukup.',
            ],
        ];

        foreach ($data as $item) {
            MealPlanItem::updateOrCreate(
                [
                    'meal_plan_id' => $item['meal_plan_id'],
                    'makanan_id' => $item['makanan_id'],
                    'waktu_makan' => $item['waktu_makan'],
                ],
                [
                    'porsi' => $item['porsi'],
                    'sudah_dikonsumsi' => $item['sudah_dikonsumsi'],
                    'dikonsumsi_pada' => $item['dikonsumsi_pada'],
                    'catatan' => $item['catatan'],
                ]
            );
        }
    }
}