<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );


        User::firstOrCreate(
            ['email' => 'hr@example.com'],
            [
                'name' => 'HR',
                'password' => Hash::make('password'),
                'role' => 'hr',
            ]
        );

    }
}


