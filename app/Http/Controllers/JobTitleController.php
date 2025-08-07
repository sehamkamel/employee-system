<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobTitle;

class JobTitleController extends Controller
{
    public function index()
    {
        $jobTitles = JobTitle::with('department')->get();
        return view('job_titles.index', compact('jobTitles'));
    }
}
