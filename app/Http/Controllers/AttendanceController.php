<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class AttendanceController extends Controller
{
public function index()
{
    if (auth()->user()->role === 'admin' || auth()->user()->role === 'hr') {
        // 1. جيبي كل الموظفين المرتبطين باليوزر
        $employees = Employee::with('user')->get();

        // 2. جيبي الحضور لليوم الحالي
        $today = now()->toDateString();
        $attendances = Attendance::whereDate('date', $today)->get()->keyBy('employee_id');

        // 3. ابعتيهم للعرض
        return view('attendance.admin_index', compact('employees', 'attendances', 'today'));

    } else {
        // موظف
        $employee = auth()->user()->employee;
        $today = now()->toDateString();

        $attendance = Attendance::where('employee_id', $employee->id)
                                ->whereDate('date', $today)
                                ->first();

        return view('attendance.index', compact('attendance'));
    }
}


public function checkIn()
    {
        $user = Auth::user();

        // التحقق من إن المستخدم موظف فقط
        if (!in_array($user->role, ['employee'])) {
            return redirect()->back()->with('error', 'Access denied.');
        }

        $today = Carbon::today()->toDateString();

        // التحقق من وجود تسجيل مسبق
       $existingAttendance = Attendance::where('employee_id', $user->employee->id)

            ->whereDate('date', $today)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }

        // تحديد الوقت الحالي
        $now = Carbon::now();
       
        $checkInTime = $now->format('H:i');

        // تحديد الحالة حسب الوقت
        $startTime = Carbon::createFromTime(6, 30); // 6:30 AM
        $onTimeEnd = Carbon::createFromTime(9, 0);  // 9:00 AM
        $lateEnd = Carbon::createFromTime(10, 0);   // 10:00 AM

        if ($now->lt($startTime) || $now->gt($lateEnd)) {
            return redirect()->back()->with('error', 'Check-in is allowed only between 07:30 AM and 10:00 AM.');
        }
        $status = 'absent';

        if  ($now->between($onTimeEnd->copy()->addSecond(), $lateEnd)) {
            $status = 'on-time';
        } elseif ($now->between($onTimeEnd->addSecond(), $lateEnd)) {
            $status = 'late';
        }

        // إنشاء سجل الحضور
        Attendance::create([
        
             'employee_id' => $user->employee->id,
            'date' => $today,
            'check_in_time' => $checkInTime,
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Check-in recorded successfully. Status: ' . $status);
    }

    public function checkOut()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $attendance =  Attendance::where('employee_id', $user->employee->id)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'You have not checked in yet.');
        }

        if ($attendance->check_out_time) {
            return redirect()->back()->with('error', 'You have already checked out.');
        }

        $attendance->update([
            'check_out_time' => Carbon::now()->format('H:i'),
        ]);

        return redirect()->back()->with('success', 'Check-out recorded successfully.');
    }
}




