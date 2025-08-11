<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show($id)
{
    $leave = Leave::with('employee')->findOrFail($id);
    return view('leaves.show', compact('leave'));
}

    public function index()
    {
        // بنجيب كل الإجازات مع بيانات الموظف المرتبط بيها
        $leaves = Leave::with('employee')->latest()->get();

        return view('leaves.index', compact('leaves'));
    }
public function updateStatus($id, $status)
{
    $leave = LeaveRequest::findOrFail($id);
    $leave->status = $status;
    $leave->save();

    return redirect()->back()->with('success', 'تم تحديث حالة الطلب.');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // بنجيب الموظفين عشان نعرضهم في Dropdown
        $employees = Employee::orderBy('name')->get();

        return view('leaves.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type'  => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'status'      => 'required|in:Pending,Approved,Rejected',
            'reason'      => 'nullable|string',
        ]);

        Leave::create($request->all());

        return redirect()->route('leaves.index')
                         ->with('success', 'Leave created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        $employees = Employee::orderBy('name')->get();

        return view('leaves.edit', compact('leave', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type'  => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'status'      => 'required|in:Pending,Approved,Rejected',
            'reason'      => 'nullable|string',
        ]);

        $leave->update($request->all());

        return redirect()->route('leaves.index')
                         ->with('success', 'Leave updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        $leave->delete();

        return redirect()->route('leaves.index')
                         ->with('success', 'Leave deleted successfully.');
    }
}
