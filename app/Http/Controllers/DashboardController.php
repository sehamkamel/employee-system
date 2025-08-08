<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
    {
   


    // بيانات مؤقتة لحين ربط الجداول
    $usersCount = 10;
    $employeesCount = 7;
    $departmentsCount = 3;
    $jobTitlesCount = 5;

    return view('dashboard.index', compact(
        'usersCount',
        'employeesCount',
        'departmentsCount',
        'jobTitlesCount'
    ));


}

    }


