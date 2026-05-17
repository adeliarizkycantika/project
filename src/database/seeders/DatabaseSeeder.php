<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            KategoriMakananSeeder::class,
            MakananSeeder::class,
            BahanMakananSeeder::class,
            MealPlanSeeder::class,
            MealPlanItemSeeder::class,
            ItemDaftarBelanjaSeeder::class,
        ]);
    }
}