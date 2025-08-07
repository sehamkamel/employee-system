<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Software Development', 'description' => 'Handles all coding and software projects.'],
            ['name' => 'UI/UX Design',          'description' => 'Responsible for designing user interfaces and experiences.'],
            ['name' => 'Quality Assurance',     'description' => 'Ensures software quality through testing.'],
            ['name' => 'DevOps',                'description' => 'Manages infrastructure and deployments.'],
            ['name' => 'Product Management',    'description' => 'Oversees product strategy and roadmap.'],
            ['name' => 'IT Support',            'description' => 'Provides technical support and troubleshooting.'],
            ['name' => 'Human Resources',       'description' => 'Handles employee-related matters and hiring.'],
            ['name' => 'Finance',               'description' => 'Manages company finances and payroll.'],
        ];

        foreach ($departments as $data) {
            Department::create($data);
        }
    }
}
