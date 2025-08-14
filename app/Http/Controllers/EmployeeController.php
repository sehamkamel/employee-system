<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;




class EmployeeController extends Controller
{
    // عرض كل الموظفين
 public function index(Request $request)
{
    $search = $request->input('search');

    $employees = Employee::when($search, function ($query, $search) {
        return $query->where('name', 'LIKE', "%{$search}%");
    })
    ->latest()
    ->paginate(10);

    return view('employees.index', compact('employees', 'search'));
}


    // عرض صفحة إنشاء موظف جديد
    public function create()
{
    // جلب الأقسام مع الوظائف، وتحويلهم لمصفوفة بسيطة لتسهيل ال json
    $departments = Department::with('jobTitles')->get()->map(function($d) {
        return [
            'id' => $d->id,
            'name' => $d->name,
            'job_titles' => $d->jobTitles->map(function($j) {
                return ['id' => $j->id, 'name' => $j->name];
            })->toArray(),
        ];
    });

    return view('employees.create', compact('departments'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name'       => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'phone'      => 'required|string|max:20',
        'department' => 'required|string|max:255',    // نص (اسم القسم)
        'job_title'  => 'required|string|max:255',    // نص (اسم الوظيفة)
        'hired_at'   => 'nullable|date',
        'salary'     => 'nullable|numeric',
        'address'    => 'nullable|string|max:255',
        'password'   => 'required|string|min:6|confirmed',
    ]);

    // Create user account first
    $user = User::create([
        'name'     => $validated['name'],
        'email'    => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role'     => 'employee',
    ]);

    // Create employee record (store department & job_title as text)
    Employee::create([
        'name'      => $validated['name'],
        'email'     => $validated['email'],
        'phone'     => $validated['phone'],
        'department'=> $validated['department'],
        'job_title' => $validated['job_title'],
        'hired_at'  => $validated['hired_at'] ?? null,
        'salary'    => $validated['salary'] ?? null,
        'address'   => $validated['address'] ?? null,
        'user_id'   => $user->id,
    ]);

    return redirect()->route('employees.index')->with('success', 'Employee created successfully.');}



    // عرض تفاصيل موظف معين (لو حبيتِ تفعليه بعدين)
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    // عرض صفحة التعديل
    public function edit(Employee $employee)
    {
           $departments = Department::with('jobTitles')->get();

    return view('employees.edit', compact('employee', 'departments'));
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
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    // تحديث بيانات الموظف
    $employee->update($request->except('password', 'password_confirmation'));

    // تحديث بيانات المستخدم المرتبط (في جدول users)
    $user = $employee->user;
    if ($user) {
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
           $user->password = Hash::make($request->password);

        }

        $user->save();
    }

    return redirect()->route('employees.index')
                     ->with('success', 'Employee updated successfully.');
}


    // حذف موظف
  public function destroy(Employee $employee)
{
    // لو الموظف مرتبط بـ user
    if ($employee->user) {
        $employee->user->delete();  // حذف المستخدم أولاً
    } else {
        $employee->delete(); // لو ماعندوش user (نادر بس ممكن يحصل)، نحذف الموظف فقط
    }

    return redirect()->route('employees.index')
                     ->with('success', 'Employee and user deleted successfully.');
}

}

