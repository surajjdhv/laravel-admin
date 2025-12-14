<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // User management permissions
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Role management permissions
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',

            // Permission management permissions
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Admin role and assign all permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($permissions);

        // Create Member role with limited permissions
        $memberRole = Role::firstOrCreate(['name' => 'Member', 'guard_name' => 'web']);
        // Members have no special permissions by default
        $memberRole->syncPermissions([]);
    }
}

