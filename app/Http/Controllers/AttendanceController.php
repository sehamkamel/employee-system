<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
public function index(Request $request)
{
    $timezone = 'Africa/Cairo';
    $date = $request->input('date', Carbon::now($timezone)->toDateString());
    $today = Carbon::now($timezone)->startOfDay();

    // لو المستخدم Admin أو HR
    if (auth()->user()->role === 'admin' || auth()->user()->role === 'hr') {
        // جلب الموظفين اللي تم تعيينهم قبل أو في التاريخ المختار
        $employees = Employee::with('user')
            ->whereDate('created_at', '<=', $date)
            ->get();

        // لكل موظف، نملأ الحضور أو الغياب لكل يوم من تعيينه حتى التاريخ المحدد
        foreach ($employees as $employee) {
            $startDate = Carbon::parse($employee->created_at, $timezone)->toDateString();
            $currentDate = Carbon::parse($startDate, $timezone);

            while ($currentDate->lte(Carbon::parse($date, $timezone))) {

                // لو التاريخ هو اليوم الحالي ولسه وقت العمل مفتوح → متسجلش غياب
                if ($currentDate->isSameDay($today)) {
                    $now = Carbon::now($timezone);
                    $lateEndMinutes = 13 * 60; // 1:00 PM
                    $nowMinutes = $now->hour * 60 + $now->minute;

                    if ($nowMinutes <= $lateEndMinutes) {
                        $currentDate->addDay();
                        continue;
                    }
                }

                // نتحقق هل الموظف في إجازة معتمدة في اليوم ده
                $hasLeave = LeaveRequest::where('employee_id', $employee->id)
                    ->where('status', 'Approved') // انتبه هنا 'Approved' مع حرف كبير
                    ->whereDate('start_date', '<=', $currentDate)
                    ->whereDate('end_date', '>=', $currentDate)
                    ->exists();

                // نحدد الحالة: إجازة لو في إجازة، وإلا غياب
                $status = $hasLeave ? 'leave' : 'absent';

                // نتأكد إنه ما فيش سجل حضور أو غياب موجود بالفعل في نفس اليوم
                $exists = Attendance::where('employee_id', $employee->id)
                    ->whereDate('date', $currentDate->toDateString())
                    ->exists();

                if (!$exists) {
                    Attendance::create([
                        'employee_id' => $employee->id,
                        'date' => $currentDate->toDateString(),
                        'status' => $status,
                    ]);
                }

                $currentDate->addDay();
            }
        }

        // جلب سجلات الحضور/الغياب لليوم المختار
        $attendances = Attendance::whereDate('date', $date)
            ->get()
            ->keyBy('employee_id');

        // لو مفيش سجل حضور معين لموظف في التاريخ ده، نتحقق إذا هو في إجازة
        foreach ($employees as $employee) {
            if (!isset($attendances[$employee->id])) {
                $onLeave = LeaveRequest::where('employee_id', $employee->id)
                    ->where('status', 'Approved')
                    ->whereDate('start_date', '<=', $date)
                    ->whereDate('end_date', '>=', $date)
                    ->exists();

                if ($onLeave) {
                    // سجل وهمي للعرض فقط
                    $attendances[$employee->id] = (object) [
                        'date' => $date,
                        'check_in' => null,
                        'check_out' => null,
                        'status' => 'leave',
                    ];
                }
            }
        }

        return view('attendance.admin_index', [
            'employees' => $employees,
            'attendances' => $attendances,
            'date' => $date,
        ]);
    }

    // لو المستخدم موظف عادي
    $employee = auth()->user()->employee;
    if (!$employee) {
        return redirect()->back()->with('error', 'No employee record found for your account.');
    }

    $attendance = Attendance::where('employee_id', $employee->id)
        ->whereDate('date', $date)
        ->first();

    // لو مفيش سجل حضور للموظف، شيك إذا هو في إجازة في التاريخ ده
    if (!$attendance) {
        $onLeave = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'Approved')
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->exists();

        if ($onLeave) {
            $attendance = (object) [
                'date' => $date,
                'check_in' => null,
                'check_out' => null,
                'status' => 'leave',
            ];
        }
    }

    return view('attendance.index', [
        'attendance' => $attendance,
        'date' => $date
    ]);
}


 public function checkIn()
{
    $timezone = 'Africa/Cairo';
    $user = Auth::user();

    if ($user->role !== 'employee') {
        return redirect()->back()->with('error', 'Access denied.');
    }

    $today = Carbon::now($timezone)->toDateString();
    $now = Carbon::now($timezone);
    $checkInTime = $now->format('H:i');

    // **تحقق من وجود إجازة مفعلة اليوم**
    $onLeave = LeaveRequest::where('employee_id', $user->employee->id)
        ->where('status', 'approved')
        ->whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->exists();

    if ($onLeave) {
        return redirect()->back()->with('error', 'You are currently on leave and cannot check in.');
    }

    // تحويل الوقت الحالي للدقائق
    $nowMinutes = $now->hour * 60 + $now->minute;

    // أوقات السماح بالدقائق
    $startMinutes = 2 * 60;       // 11:00 AM
    $onTimeEndMinutes = 11 * 60 + 30; // 11:30 AM
    $lateEndMinutes = 15 * 60;     // 1:00 PM

    // لو خارج الرينج
    if ($nowMinutes < $startMinutes || $nowMinutes > $lateEndMinutes) {
        return redirect()->back()->with('error',
            "Check-in is allowed only between 11:00 AM and 1:00 PM. 
            Current time: {$now->format('H:i')} ({$timezone})"
        );
    }

    // تحديد الحالة
    if ($nowMinutes <= $onTimeEndMinutes) {
        $status = 'ontime';
    } else {
        $status = 'late';
    }

    // لو في سجل Absent يتعدل
    $existingAttendance = Attendance::where('employee_id', $user->employee->id)
        ->whereDate('date', $today)
        ->first();

    if ($existingAttendance && $existingAttendance->status !== 'absent') {
        return redirect()->back()->with('error', 'You have already checked in today.');
    }

    if ($existingAttendance) {
        $existingAttendance->update([
            'check_in' => $checkInTime,
            'status' => $status,
        ]);
    } else {
        Attendance::create([
            'employee_id' => $user->employee->id,
            'date' => $today,
            'check_in' => $checkInTime,
            'status' => $status,
        ]);
    }

    return redirect()->back()->with('success', "Check-in recorded successfully. Status: $status");
}


public function checkOut()
{
    $timezone = 'Africa/Cairo';
    $user = Auth::user();

    if ($user->role !== 'employee') {
        return redirect()->back()->with('error', 'Access denied.');
    }

    $today = Carbon::now($timezone)->toDateString();

    $attendance = Attendance::where('employee_id', $user->employee->id)
        ->whereDate('date', $today)
        ->first();

    if (!$attendance) {
        return redirect()->back()->with('error', 'You have not checked in today.');
    }

    if (Carbon::parse($attendance->date, $timezone)->lt(Carbon::now($timezone)->startOfDay())) {
        return redirect()->back()->with('error', 'You cannot modify past attendance records.');
    }

    if ($attendance->check_out !== null) {
        return redirect()->back()->with('error', 'You have already checked out today.');
    }

    // التأكد من وجود وقت Check In
    if (!$attendance->check_in) {
        return redirect()->back()->with('error', 'You must check in before checking out.');
    }

    // التحقق من مرور 6 ساعات على الأقل من وقت Check In
    $checkInTime = Carbon::parse($attendance->check_in, $timezone);
    $hoursWorked = $checkInTime->diffInHours(Carbon::now($timezone));

    if ($hoursWorked < 6) {
        return redirect()->back()->with('error', 'You must work at least 6 hours before checking out.');
    }

    $attendance->update([
        'check_out' => Carbon::now($timezone)->format('H:i'),
    ]);

    return redirect()->back()->with('success', 'Check-out recorded successfully.');
}

}





