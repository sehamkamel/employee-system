<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class MarkAbsentEmployees extends Command
{
    protected $signature = 'attendance:mark-absent';
    protected $description = 'Mark employees who did not check in as absent';

    public function handle()
    {
        $today = Carbon::today();

        $employees = Employee::all();

        foreach ($employees as $employee) {
            $hasAttendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('created_at', $today)
                ->exists();

            if (!$hasAttendance) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'check_in' => null,
                    'check_out' => null,
                    'status' => 'absent', // assuming it's an ENUM
                      'date' => Carbon::today()->toDateString(),
                ]);

                $this->info("Marked employee ID {$employee->id} as absent.");
            }
        }

        $this->info('Absent marking process completed.');
    }
}

