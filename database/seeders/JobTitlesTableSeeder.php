<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobTitle;
use App\Models\Department;

class JobTitlesTableSeeder extends Seeder
{
    public function run(): void
    {
        // نحصل على الـ IDs للأقسام بناءً على الاسم:
        $deptIds = Department::pluck('id', 'name');

        $jobTitles = [
            // Software Development
            ['name'=>'Backend Developer',           'description'=>'Responsible for server-side logic and database integration.',                 'department_id'=>$deptIds['Software Development']],
            ['name'=>'Frontend Developer',          'description'=>'Builds the visual and interactive elements of websites.',                         'department_id'=>$deptIds['Software Development']],
            ['name'=>'Full Stack Developer',        'description'=>'Handles both frontend and backend development.',                                'department_id'=>$deptIds['Software Development']],
            ['name'=>'Mobile Developer',            'description'=>'Creates apps for Android and iOS platforms.',                                   'department_id'=>$deptIds['Software Development']],
            ['name'=>'Software Architect',          'description'=>'Designs the high-level structure of software systems.',                         'department_id'=>$deptIds['Software Development']],

            // UI/UX Design
            ['name'=>'UI Designer',                 'description'=>'Designs the layout and visual elements of interfaces.',                         'department_id'=>$deptIds['UI/UX Design']],
            ['name'=>'UX Designer',                 'description'=>'Enhances user satisfaction through better usability.',                         'department_id'=>$deptIds['UI/UX Design']],
            ['name'=>'Product Designer',            'description'=>'Combines UI and UX to deliver complete product design.',                       'department_id'=>$deptIds['UI/UX Design']],
            ['name'=>'Interaction Designer',        'description'=>'Focuses on how users interact with the interface.',                            'department_id'=>$deptIds['UI/UX Design']],
            ['name'=>'UX Researcher',               'description'=>'Conducts research to understand user behavior.',                               'department_id'=>$deptIds['UI/UX Design']],

            // Quality Assurance
            ['name'=>'QA Tester',                   'description'=>'Tests software to ensure it meets requirements.',                            'department_id'=>$deptIds['Quality Assurance']],
            ['name'=>'QA Automation Engineer',      'description'=>'Builds automated tests to speed up QA processes.',                            'department_id'=>$deptIds['Quality Assurance']],
            ['name'=>'Test Analyst',                'description'=>'Analyzes test results and writes test cases.',                                'department_id'=>$deptIds['Quality Assurance']],
            ['name'=>'QA Lead',                     'description'=>'Leads the QA team and plans testing strategies.',                             'department_id'=>$deptIds['Quality Assurance']],
            ['name'=>'QA Engineer',                 'description'=>'Designs and implements quality assurance solutions.',                         'department_id'=>$deptIds['Quality Assurance']],

            // DevOps
            ['name'=>'DevOps Engineer',             'description'=>'Manages deployment pipelines and infrastructure.',                           'department_id'=>$deptIds['DevOps']],
            ['name'=>'Site Reliability Engineer',   'description'=>'Ensures systems are reliable and scalable.',                                  'department_id'=>$deptIds['DevOps']],
            ['name'=>'Build & Release Engineer',    'description'=>'Automates build and release processes.',                                      'department_id'=>$deptIds['DevOps']],
            ['name'=>'Cloud Infrastructure Engineer','description'=>'Designs and maintains cloud environments.',                                  'department_id'=>$deptIds['DevOps']],
            ['name'=>'Security Engineer',           'description'=>'Implements security best practices and monitors compliance.',                  'department_id'=>$deptIds['DevOps']],

            // Product Management
            ['name'=>'Product Manager',             'description'=>'Leads product planning and execution throughout the lifecycle.',             'department_id'=>$deptIds['Product Management']],
            ['name'=>'Technical Product Manager',   'description'=>'Bridges technical teams and product vision.',                                'department_id'=>$deptIds['Product Management']],
            ['name'=>'Product Owner',               'description'=>'Represents stakeholders and defines product backlog.',                        'department_id'=>$deptIds['Product Management']],
            ['name'=>'Business Analyst',            'description'=>'Analyzes business needs and translates into requirements.',                   'department_id'=>$deptIds['Product Management']],
            ['name'=>'Market Researcher',           'description'=>'Studies market trends to inform product strategy.',                         'department_id'=>$deptIds['Product Management']],

            // IT Support
            ['name'=>'IT Support Specialist',       'description'=>'Provides helpdesk support to end users.',                                   'department_id'=>$deptIds['IT Support']],
            ['name'=>'System Administrator',        'description'=>'Manages servers and system configurations.',                                'department_id'=>$deptIds['IT Support']],
            ['name'=>'Network Administrator',       'description'=>'Maintains network infrastructure and security.',                            'department_id'=>$deptIds['IT Support']],
            ['name'=>'Help Desk Technician',        'description'=>'Responds to technical tickets and assists users.',                           'department_id'=>$deptIds['IT Support']],
            ['name'=>'IT Coordinator',              'description'=>'Coordinates IT projects and resources.',                                     'department_id'=>$deptIds['IT Support']],

            // Human Resources
            ['name'=>'HR Manager',                  'description'=>'Oversees HR policies and team.',                                            'department_id'=>$deptIds['Human Resources']],
            ['name'=>'Recruitment Specialist',      'description'=>'Manages end-to-end hiring process.',                                        'department_id'=>$deptIds['Human Resources']],
            ['name'=>'HR Coordinator',              'description'=>'Supports employee relations and HR admin tasks.',                            'department_id'=>$deptIds['Human Resources']],
            ['name'=>'Talent Acquisition Specialist','description'=>'Sources and attracts top talent.',                                          'department_id'=>$deptIds['Human Resources']],
            ['name'=>'Employee Relations Officer',  'description'=>'Handles workplace conflict and engagement.',                                'department_id'=>$deptIds['Human Resources']],

            // Finance
            ['name'=>'Accountant',                  'description'=>'Prepares financial statements and reports.',                                'department_id'=>$deptIds['Finance']],
            ['name'=>'Financial Analyst',           'description'=>'Analyzes financial data to guide business decisions.',                       'department_id'=>$deptIds['Finance']],
            ['name'=>'Payroll Specialist',          'description'=>'Processes payroll and benefits administration.',                             'department_id'=>$deptIds['Finance']],
            ['name'=>'Finance Manager',             'description'=>'Leads financial planning and analysis.',                                     'department_id'=>$deptIds['Finance']],
            ['name'=>'Auditor',                     'description'=>'Conducts internal audits to ensure compliance.',                             'department_id'=>$deptIds['Finance']],
        ];

        foreach ($jobTitles as $data) {
            JobTitle::create($data);
        }
    }
}
