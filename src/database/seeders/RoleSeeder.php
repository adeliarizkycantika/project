<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        if (! class_exists(\Spatie\Permission\Models\Role::class)) {
            return;
        }

        if (! Schema::hasTable('roles')) {
            return;
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = [
            'super_admin',
            'admin',
            'user',
        ];

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        if (
            Schema::hasTable('permissions') &&
            Schema::hasTable('role_has_permissions')
        ) {
            $permissions = \Spatie\Permission\Models\Permission::query()
                ->where('guard_name', 'web')
                ->get();

            $superAdminRole = \Spatie\Permission\Models\Role::where('name', 'super_admin')
                ->where('guard_name', 'web')
                ->first();

            $adminRole = \Spatie\Permission\Models\Role::where('name', 'admin')
                ->where('guard_name', 'web')
                ->first();

            if ($superAdminRole && $permissions->isNotEmpty()) {
                $superAdminRole->syncPermissions($permissions);
            }

            if ($adminRole && $permissions->isNotEmpty()) {
                $adminRole->syncPermissions($permissions);
            }
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}