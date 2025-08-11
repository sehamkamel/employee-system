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
        if (auth()->user()->role === 'hr') {
            // HR يشوف كل الطلبات
            $leaveRequests = LeaveRequest::with('employee')->latest()->get();
        } else {
            // الموظف يشوف طلباته فقط
            $employee = auth()->user()->employee;
            $leaveRequests = $employee->leaveRequests()->latest()->get();
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
