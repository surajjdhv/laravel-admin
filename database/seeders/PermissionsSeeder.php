<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'log-viewer.view',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'users.roles.assign',
            'activity-logs.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $legacyAdmin = Role::where('name', 'admin')->first();

        if ($legacyAdmin) {
            $legacyAdmin->update(['name' => 'Admin']);
        }

        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $adminRole->syncPermissions($permissions);

        User::withoutGlobalScope('onlyActive')
            ->where('email', 'admin@admin.com')
            ->get()
            ->each(function (User $user) use ($adminRole): void {
                $user->syncRoles([$adminRole]);
            });
    }
}
