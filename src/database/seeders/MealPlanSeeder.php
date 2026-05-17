<?php

namespace Database\Seeders;

use App\Models\MealPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class MealPlanSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@mealplanner.test')->first();

        if (! $user) {
            return;
        }

        MealPlan::updateOrCreate(
            [
                'user_id' => $user->id,
                'judul' => 'Meal Plan Hari Ini',
                'tanggal_rencana' => now()->toDateString(),
            ],
            [
                'catatan' => 'Contoh meal plan harian untuk kebutuhan testing sistem.',
            ]
        );

        MealPlan::updateOrCreate(
            [
                'user_id' => $user->id,
                'judul' => 'Meal Plan Besok',
                'tanggal_rencana' => now()->addDay()->toDateString(),
            ],
            [
                'catatan' => 'Contoh meal plan untuk hari berikutnya.',
            ]
        );
    }
}