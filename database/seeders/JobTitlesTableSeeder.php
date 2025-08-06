<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobTitle;
use App\Models\Department;

class JobTitlesTableSeeder extends Seeder
{
    public function run(): void
    {
        $softwareDev = Department::where('name', 'Software Development')->first()->id;
        $uiux = Department::where('name', 'UI/UX Design')->first()->id;
        $qa = Department::where('name', 'Quality Assurance')->first()->id;
        $devops = Department::where('name', 'DevOps')->first()->id;
        $product = Department::where('name', 'Product Management')->first()->id;

        $jobTitles = [
            [
                'name' => 'Backend Developer',
                'description' => 'Responsible for server-side logic and database integration.',
                'department_id' => $softwareDev,
            ],
            [
                'name' => 'Frontend Developer',
                'description' => 'Builds the visual and interactive elements of websites.',
                'department_id' => $softwareDev,
            ],
            [
                'name' => 'Full Stack Developer',
                'description' => 'Handles both frontend and backend development.',
                'department_id' => $softwareDev,
            ],
            [
                'name' => 'Mobile Developer',
                'description' => 'Creates apps for Android and iOS platforms.',
                'department_id' => $softwareDev,
            ],
            [
                'name' => 'Software Architect',
                'description' => 'Designs the high-level structure of software systems.',
                'department_id' => $softwareDev,
            ],
            [
                'name' => 'UI Designer',
                'description' => 'Designs the layout and visual elements of interfaces.',
                'department_id' => $uiux,
            ],
            [
                'name' => 'UX Designer',
                'description' => 'Enhances user satisfaction through better usability.',
                'department_id' => $uiux,
            ],
            [
                'name' => 'QA Tester',
                'description' => 'Tests applications for bugs and functionality.',
                'department_id' => $qa,
            ],
            [
                'name' => 'DevOps Engineer',
                'description' => 'Manages deployment pipelines and infrastructure.',
                'department_id' => $devops,
            ],
            [
                'name' => 'Product Manager',
                'description' => 'Leads product planning and execution throughout the lifecycle.',
                'department_id' => $product,
            ],
        ];

        foreach ($jobTitles as $title) {
            JobTitle::create($title);
        }
    }
}
