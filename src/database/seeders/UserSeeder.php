<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            [
                'email' => 'admin@mealplanner.test',
            ],
            [
                'name' => 'Admin Meal Planner',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'daily_calorie_target' => 2000,
            ]
        );

        if (
            method_exists($admin, 'syncRoles') &&
            Schema::hasTable('roles') &&
            Schema::hasTable('model_has_roles')
        ) {
            $admin->syncRoles(['super_admin', 'admin']);
        }

        $user = User::updateOrCreate(
            [
                'email' => 'user@mealplanner.test',
            ],
            [
                'name' => 'User Test',
                'password' => Hash::make('password'),
                'role' => 'user',
                'daily_calorie_target' => 2000,
            ]
        );

        if (
            method_exists($user, 'syncRoles') &&
            Schema::hasTable('roles') &&
            Schema::hasTable('model_has_roles')
        ) {
            $user->syncRoles(['user']);
        }
    }
}