<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $timezone = 'Africa/Cairo';
        $date = $request->input('date', Carbon::now($timezone)->toDateString());
        $today = Carbon::now($timezone)->startOfDay();

        // لو Admin أو HR
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'hr') {
            // هات الموظفين اللي كانوا موجودين قبل أو في التاريخ المحدد
            $employees = Employee::with('user')
                ->whereDate('created_at', '<=', $date)
                ->get();

            foreach ($employees as $employee) {
                // من أول تاريخ تعيين الموظف لحد التاريخ المختار
                $startDate = Carbon::parse($employee->created_at, $timezone)->toDateString();
                $currentDate = Carbon::parse($startDate, $timezone);

                while ($currentDate->lte(Carbon::parse($date, $timezone))) {
                    // لو التاريخ هو النهارده ولسه وقت العمل مفتوح → متسجلش غياب
                    if ($currentDate->isSameDay($today)) {
                        $now = Carbon::now($timezone);
                        $lateEndMinutes = 13 * 60; // 1:00 PM
                        $nowMinutes = $now->hour * 60 + $now->minute;

                        if ($nowMinutes <= $lateEndMinutes) {
                            $currentDate->addDay();
                            continue;
                        }
                    }

                    // لو مفيش حضور مسجل، ضيف غياب
                    $exists = Attendance::where('employee_id', $employee->id)
                        ->whereDate('date', $currentDate->toDateString())
                        ->exists();

                    if (!$exists) {
                        Attendance::create([
                            'employee_id' => $employee->id,
                            'date' => $currentDate->toDateString(),
                            'status' => 'absent'
                        ]);
                    }

                    $currentDate->addDay();
                }
            }

            $attendances = Attendance::whereDate('date', $date)
                ->get()
                ->keyBy('employee_id');

            return view('attendance.admin_index', [
                'employees' => $employees,
                'attendances' => $attendances,
                'date' => $date,
            ]);
        }

        // لو موظف عادي
        $employee = auth()->user()->employee;
        if (!$employee) {
            return redirect()->back()->with('error', 'No employee record found for your account.');
        }

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $date)
            ->first();

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

        // الوقت بالدقائق
        $nowMinutes = $now->hour * 60 + $now->minute;

        // رينج الحضور
        $startMinutes = 11 * 60;        // 11:00 AM
        $onTimeEndMinutes = 11 * 60 + 30; // 11:30 AM
        $lateEndMinutes = 13 * 60;      // 1:00 PM

        if ($nowMinutes < $startMinutes || $nowMinutes > $lateEndMinutes) {
            return redirect()->back()->with('error',
                "Check-in is allowed only between 11:00 AM and 1:00 PM. Current time: {$now->format('H:i')} ({$timezone})"
            );
        }

        $status = ($nowMinutes <= $onTimeEndMinutes) ? 'ontime' : 'late';

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

        $attendance->update([
            'check_out' => Carbon::now($timezone)->format('H:i'),
        ]);

        return redirect()->back()->with('success', 'Check-out recorded successfully.');
    }
}





