<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\CalorieCalculatorService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (class_exists(PermissionRegistrar::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        }

        if (class_exists(Role::class) && Schema::hasTable('roles')) {
            Role::firstOrCreate([
                'name' => 'super_admin',
                'guard_name' => 'web',
            ]);

            Role::firstOrCreate([
                'name' => 'admin',
                'guard_name' => 'web',
            ]);

            Role::firstOrCreate([
                'name' => 'user',
                'guard_name' => 'web',
            ]);
        }

        $calculator = app(CalorieCalculatorService::class);

        $adminCalories = $calculator->calculateDailyCalories(
            gender: 'female',
            age: 21,
            heightCm: 160,
            weightKg: 55,
            activityLevel: 'jarang_berolahraga'
        );

        $admin = User::updateOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin Meal Planner',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'gender' => 'female',
                'age' => 21,
                'height_cm' => 160,
                'weight_kg' => 55,
                'activity_level' => 'jarang_berolahraga',
                'daily_calorie_target' => $adminCalories,
            ]
        );

        if (
            method_exists($admin, 'syncRoles') &&
            Schema::hasTable('roles') &&
            Schema::hasTable('model_has_roles')
        ) {
            $admin->syncRoles([
                'super_admin',
                'admin',
            ]);
        }

        $userCalories = $calculator->calculateDailyCalories(
            gender: 'female',
            age: 21,
            heightCm: 160,
            weightKg: 55,
            activityLevel: 'jarang_berolahraga'
        );

        $user = User::updateOrCreate(
            [
                'email' => 'user@mealplanner.test',
            ],
            [
                'name' => 'User Test',
                'password' => Hash::make('password'),
                'role' => 'user',
                'gender' => 'female',
                'age' => 21,
                'height_cm' => 160,
                'weight_kg' => 55,
                'activity_level' => 'jarang_berolahraga',
                'daily_calorie_target' => $userCalories,
            ]
        );

        if (
            method_exists($user, 'syncRoles') &&
            Schema::hasTable('roles') &&
            Schema::hasTable('model_has_roles')
        ) {
            $user->syncRoles([
                'user',
            ]);
        }
    }
}