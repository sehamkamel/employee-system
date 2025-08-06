@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Employees</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Department</th>
            <th>Job Title</th>
            <th>Job Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $index => $employee)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->department->name ?? '-' }}</td>
            <td>{{ $employee->jobTitle->name ?? '-' }}</td>
            <td>{{ $employee->jobTitle->description ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

    <div class="mt-3">
        {{ $employees->links() }}
    </div>
</div>
@endsection
