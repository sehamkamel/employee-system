@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Employees</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
    </div>

 


    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Job Title</th>
                <th>Hired At</th>
                <th>Salary</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $index => $employee)
                <tr>
                    <td>{{ $index + $employees->firstItem() }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->job_title ?? '-' }}</td>
                    <td>{{ $employee->hired_at ?? '-' }}</td>
                    <td>{{ $employee->salary ?? '-' }}</td>
                    <td>{{ $employee->address ?? '-' }}</td>
                <td>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm">View</a>
    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>

    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
            Delete
        </button>
    </form>
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No employees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $employees->links() }}
    </div>
</div>
@endsection
