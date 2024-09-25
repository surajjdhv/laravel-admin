<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin@123',
            'type' => User::TYPE_ADMIN,
            'created_by' => 1,
        ]);

        // User::factory()->count(99)->create();
    }
}
