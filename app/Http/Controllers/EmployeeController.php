<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;




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
        'name' => 'required|string',
        'email' => 'required|email|unique:employees,email|unique:users,email',
        'phone' => 'required|string',
        'department' => 'required|string',
        'job_title' => 'nullable|string',
        'hired_at' => 'nullable|date',
        'salary' => 'nullable|numeric',
        'address' => 'nullable|string',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // إنشاء حساب في جدول users أولًا
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'employee',
    ]);

    // إضافة الموظف وربطه بالمستخدم
    $employee = Employee::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'department' => $request->department,
        'job_title' => $request->job_title,
        'hired_at' => $request->hired_at,
        'salary' => $request->salary,
        'address' => $request->address,
        'user_id' => $user->id, // الربط بين الموظف والمستخدم
    ]);

    return redirect()->route('employees.index')->with('success', 'Employee created successfully');
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
        $employee->delete();

        return redirect()->route('employees.index')
                         ->with('success', 'Employee deleted successfully.');
    }
}

