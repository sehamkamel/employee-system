@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Attendance Records</h2>

   
        <table class="table table-bordered table-hover">
        <thead class="table-light"></thead>
            <tr>
                <th>Employee</th>
                <th>Date</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
            </tr>
        </thead>
<tbody>
    @foreach ($employees as $employee)
        @php
            $attendance = $attendances[$employee->id] ?? null;
        @endphp
        <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $today }}</td>
            <td>{{ $attendance?->check_in ?? '-' }}</td>
            <td>{{ $attendance?->check_out ?? '-' }}</td>
            <td>
                @if ($attendance)
                    @if ($attendance->status == 'ontime')
                        <span class="badge bg-success">On Time</span>
                    @elseif ($attendance->status == 'late')
                        <span class="badge bg-warning text-dark">Late</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($attendance->status) }}</span>
                    @endif
                @else
                    <span class="badge bg-danger">Absent</span>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>

    </table>
</div>
@endsection
