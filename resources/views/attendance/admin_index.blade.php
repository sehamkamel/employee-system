@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Attendance Records</h2>

    {{-- اختيار التاريخ --}}
    <form method="GET" action="{{ route('admin.attendance.index') }}" class="mb-4 row g-2 align-items-center">
        <div class="col-auto">
            <label for="date" class="col-form-label">Select Date:</label>
        </div>
        <div class="col-auto">
            <input type="date" name="date" id="date" class="form-control"
                   value="{{ $date }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

  
   <style>
    /* منع تكسير الكلام في الجدول */
    .table td, .table th {
        white-space: nowrap;
        vertical-align: middle;
    }

    /* تصغير حجم النص في الجدول */
    .table td {
        font-size: 14px;
    }

    /* تحسين الأزرار */
    .btn {
        transition: all 0.2s ease-in-out;
    }
    .btn:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }
</style>

<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-light">
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
    <td>{{ $attendance?->date ?? '-' }}</td>
    <td>{{ $attendance?->check_in ?? '-' }}</td>
    <td>{{ $attendance?->check_out ?? '-' }}</td>
  <td>
    @if ($attendance)
        @if ($attendance->status == 'ontime')
            <span class="badge bg-success">On Time</span>
        @elseif ($attendance->status == 'late')
            <span class="badge bg-warning text-dark">Late</span>
        @elseif ($attendance->status == 'leave')
            <span class="badge bg-primary">On Leave</span>
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
