<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin@123',
            'type' => User::TYPE_ADMIN,
            'created_by' => 1,
        ]);

        // Assign Admin role to the admin user
        $admin->assignRole('Admin');

        // User::factory()->count(99)->create();
    }
}
