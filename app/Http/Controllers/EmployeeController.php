<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // عرض كل الموظفين
    public function index()
    {
        $employees = Employee::latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    // عرض صفحة إنشاء موظف جديد
    public function create()
    {
        return view('employees.create');
    }

    // حفظ موظف جديد في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'department' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'hired_at' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Employee created successfully.');
    }

    // عرض تفاصيل موظف معين (لو حبيتِ تفعليه بعدين)
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    // عرض صفحة التعديل
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    // تحديث بيانات موظف
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:20',
            'department' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:100',
            'hired_at' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Employee updated successfully.');
    }

    // حذف موظف
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
                         ->with('success', 'Employee deleted successfully.');
    }
}

