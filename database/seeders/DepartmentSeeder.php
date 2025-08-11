<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Software Development',
                'description' => 'Handles software engineering and application development.'
            ],
            [
                'name' => 'Quality Assurance',
                'description' => 'Ensures the quality and reliability of products through testing.'
            ],
            [
                'name' => 'Project Management',
                'description' => 'Plans and oversees project execution and delivery.'
            ],
            [
                'name' => 'Human Resources',
                'description' => 'Manages recruitment, employee relations, and benefits.'
            ],
            [
                'name' => 'IT Support',
                'description' => 'Provides technical support and maintains IT infrastructure.'
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Designs user interfaces and ensures good user experience.'
            ],
            [
                'name' => 'Business Analysis',
                'description' => 'Analyzes business needs and translates them into technical solutions.'
            ],
            [
                'name' => 'Sales & Marketing',
                'description' => 'Promotes products and manages customer relationships.'
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
