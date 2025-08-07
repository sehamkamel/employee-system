<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\JobTitle;

class EmployeeController extends Controller
{
    // Display all employees
   public function index()
{
    $employees = Employee::with(['department', 'jobTitle'])->paginate(10);
    return view('employees.index', compact('employees'));
}


    // Show the form to create a new employee
    public function create()
{
    $departments = Department::all();
    // لا تجيب كل الموظفين هنا
    return view('employees.create', compact('departments'));
}


    // Store a new employee in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'job_title_id' => 'nullable|exists:job_titles,id',
            'hired_at' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Employee created successfully.');
    }

    // Show details of a specific employee
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    // Show the form to edit an existing employee
    public function edit(Employee $employee)
    {
        $departments = Department::with('jobTitles')->get();
        return view('employees.edit', compact('employee', 'departments'));
    }

    // Update an existing employee
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'job_title_id' => 'nullable|exists:job_titles,id',
            'hired_at' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Employee updated successfully.');
    }

    // Delete an employee
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
                         ->with('success', 'Employee deleted successfully.');
    }
}
