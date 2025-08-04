@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Employee Details</h2>

    <div class="card p-4">
        <h4>{{ $employee->name }}</h4>
        <p><strong>Email:</strong> {{ $employee->email }}</p>
        <p><strong>Phone:</strong> {{ $employee->phone }}</p>
        <p><strong>Department:</strong> {{ $employee->department }}</p>
        <p><strong>Job Title:</strong> {{ $employee->job_title ?? 'N/A' }}</p>
        <p><strong>Hired At:</strong> {{ $employee->hired_at ?? 'N/A' }}</p>
        <p><strong>Salary:</strong> {{ $employee->salary ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $employee->address ?? 'N/A' }}</p>

        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
@endsection
