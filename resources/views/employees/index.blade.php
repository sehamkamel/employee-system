@extends('layouts.app')

@section('content')

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

<div class="container">
    <h1 class="mb-4">Employees List</h1>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('employees.create') }}" class="btn btn-success">+ Add Employee</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Job Title</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Hired At</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $index => $employee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->department }}</td>
                        <td>{{ $employee->job_title }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->hired_at }}</td>
                        <td>${{ number_format($employee->salary, 2) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm">Show</a>
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" >Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No employees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

