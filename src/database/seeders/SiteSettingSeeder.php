<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Pola Makan Sehat',
                'site_subtitle' => 'Meal Planner & Kalori Harian',
                'logo_path' => null,
                'auth_background_path' => null,
            ]
        );
    }
}