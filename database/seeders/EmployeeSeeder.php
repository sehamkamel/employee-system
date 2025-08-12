<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // أولاً أنشئ المستخدم
        $user = User::create([
            'name' => 'Test Employee',
            'email' => 'testemployee@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);

        // ثم أنشئ الموظف مرتبط بالمستخدم
        Employee::create([
            'user_id' => $user->id,
            'name' => 'Test Employee',
            'email' => 'testemployee@example.com',
            'phone' => '0123456789',
            'department' => 'IT',
            'job_title' => 'Developer',
            'hired_at' => now(),
            'salary' => 3000,
            'address' => 'Cairo, Egypt',
        ]);
    }
}
