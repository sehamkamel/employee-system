<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class MarkAbsentEmployees extends Command
{
    /**
     * Signature: يقبل تاريخ اختياري
     * Usage:
     *  php artisan attendance:mark-absent
     *  php artisan attendance:mark-absent 2025-08-08
     */
    protected $signature = 'attendance:mark-absent {date?}';

    protected $description = 'Mark employees who did not check in as absent for the given date (default: today)';

    public function handle()
    {
        // تحديد اليوم المستهدف
        $targetDate = $this->argument('date')
            ? Carbon::parse($this->argument('date'))->startOfDay()
            : Carbon::today();

        $this->info("Marking absents for: " . $targetDate->toDateString());

        $employees = Employee::all();

        foreach ($employees as $employee) {
            // التحقق من وجود سجل في جدول الحضور لهذا اليوم
            $hasAttendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('date', $targetDate)
                ->exists();

            if (!$hasAttendance) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'check_in' => null,
                    'check_out' => null,
                    'status' => 'absent',
                    'date' => $targetDate->toDateString(),
                ]);

                $this->info("✔ Marked employee ID {$employee->id} as absent.");
            }
        }

        $this->info('✅ Absent marking process completed.');
    }
}


