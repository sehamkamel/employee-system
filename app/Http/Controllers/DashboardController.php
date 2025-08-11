<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\JobTitle;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $employeesCount = Employee::count();
        $departmentsCount = Department::count();
        $jobTitlesCount = JobTitle::count();

        return view('dashboard.index', compact(
            'usersCount',
            'employeesCount',
            'departmentsCount',
            'jobTitlesCount'
        ));
    }
}


