<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobTitle;

class JobTitleSeeder extends Seeder
{
    public function run()
    {
        $jobTitles = [
            ['name' => 'Software Engineer', 'department_id' => 1],
            ['name' => 'Backend Developer', 'department_id' => 1],
            ['name' => 'Frontend Developer', 'department_id' => 1],

            ['name' => 'QA Engineer', 'department_id' => 2],
            ['name' => 'Test Analyst', 'department_id' => 2],

            ['name' => 'Project Manager', 'department_id' => 3],
            ['name' => 'Scrum Master', 'department_id' => 3],

            ['name' => 'HR Specialist', 'department_id' => 4],
            ['name' => 'Recruiter', 'department_id' => 4],

            ['name' => 'IT Technician', 'department_id' => 5],
            ['name' => 'Help Desk Support', 'department_id' => 5],

            ['name' => 'UI Designer', 'department_id' => 6],
            ['name' => 'UX Researcher', 'department_id' => 6],

            ['name' => 'Business Analyst', 'department_id' => 7],
            ['name' => 'System Analyst', 'department_id' => 7],

            ['name' => 'Sales Executive', 'department_id' => 8],
            ['name' => 'Marketing Manager', 'department_id' => 8],
        ];

        foreach ($jobTitles as $jobTitle) {
            JobTitle::create($jobTitle);
        }
    }
}
