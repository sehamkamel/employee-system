<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    /**
     * عرض الطلبات
     */
public function index()
{
    $role = auth()->user()->role;

    if ($role === 'hr' || $role === 'admin') {
        // الـ HR والـ Admin يشوفوا كل طلبات الإجازة
        $leaveRequests = LeaveRequest::with('employee')->latest()->get();
    } elseif ($role === 'employee') {
        $employee = auth()->user()->employee;
        if (!$employee) {
            abort(403, 'Employee record not found for this user.');
        }
        $leaveRequests = $employee->leaveRequests()->latest()->get();
    } else {
        abort(403, 'Access denied.');
    }

    return view('leave_requests.index', compact('leaveRequests'));
}


    /**
     * فورم إنشاء طلب إجازة للموظف
     */
    public function create()
    {
        return view('leave_requests.create');
    }

    /**
     * حفظ طلب الإجازة
     */
public function store(Request $request)
{
    $request->validate([
        'leave_type' => 'required|string|max:255',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date'   => 'required|date|after_or_equal:start_date',
        'reason'     => 'nullable|string',
    ]);

    $employee = Auth::user()->employee;

    // تحقق إذا في إجازة متداخلة بنفس الفترة و الحالة approved أو Pending
    $overlappingLeave = LeaveRequest::where('employee_id', $employee->id)
        ->where(function($query) {
            $query->where('status', 'approved')
                  ->orWhere('status', 'Pending');
        })
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function ($query) use ($request) {
                      $query->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                  });
        })
        ->exists();

    if ($overlappingLeave) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => 'You already have a leave request overlapping with these dates.']);
    }

    LeaveRequest::create([
        'employee_id' => $employee->id,
        'leave_type'  => $request->leave_type,
        'start_date'  => $request->start_date,
        'end_date'    => $request->end_date,
        'reason'      => $request->reason,
        'status'      => 'Pending',
    ]);

    return redirect()->route('leave-requests.index')
                     ->with('success', 'Leave request submitted successfully.');
}


    /**
     * حذف طلب الإجازة
     */
    public function destroy($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        // Check ownership
        if ($leaveRequest->employee_id != auth()->user()->employee->id) {
            return redirect()->back()->with('error', 'You are not allowed to delete this request.');
        }

        // Check status
        if ($leaveRequest->status !== 'Pending') {
            return redirect()->back()->with('error', 'You can only delete requests that are still pending.');
        }

        $leaveRequest->delete();

        return redirect()->route('leave-requests.index')->with('success', 'Leave request deleted successfully.');
    }

    /**
     * تحديث حالة الطلب (موافقة / رفض) بواسطة HR
     */
    public function updateStatus($id, $status)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->status = $status;
        $leave->save();

        return redirect()->back()->with('success', 'Leave request status updated successfully.');
    }
}
