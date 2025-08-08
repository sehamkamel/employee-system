@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Edit Employee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $employee->name) }}">
            </div>
            <div class="col">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email', $employee->email) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required value="{{ old('phone', $employee->phone) }}">
            </div>
            <div class="col">
                <label>Department</label>
                <input type="text" name="department" class="form-control" required value="{{ old('department', $employee->department) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Job Title</label>
                <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $employee->job_title) }}">
            </div>
            <div class="col">
                <label>Hired At</label>
                <input type="date" name="hired_at" class="form-control" value="{{ old('hired_at', $employee->hired_at) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Salary</label>
                <input type="number" name="salary" class="form-control" step="0.01" value="{{ old('salary', $employee->salary) }}">
            </div>
            <div class="col">
                <label>Address</label>
                <textarea name="address" class="form-control">{{ old('address', $employee->address) }}</textarea>
            </div>
        </div>
        <div class="mb-3">
    <label for="password" class="form-label">New Password (leave blank to keep current)</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm New Password</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>


        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
