<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'monir112761@gmail.com'],
            [
                'name' => 'superadin',
                'password' => Hash::make('1234567890'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
    }
}
