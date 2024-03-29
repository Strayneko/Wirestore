<?php

namespace Database\Seeders;

use App\Enums\UserRoleType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@wirestore.test',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'user_role_id' => UserRoleType::Admin,
        ]);

        User::query()->create([
            'name' => 'User',
            'email' => 'user@wirestore.test',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'user_role_id' => UserRoleType::User,
        ]);
    }
}
