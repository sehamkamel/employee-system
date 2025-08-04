@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Employee</h4>
        </div>
        <div class="card-body">

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

            <form action="{{ route('employees.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    </div>
                    <div class="col">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
                    </div>
                    <div class="col">
                        <label>Department</label>
                        <input type="text" name="department" class="form-control" required value="{{ old('department') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Job Title</label>
                        <input type="text" name="job_title" class="form-control" value="{{ old('job_title') }}">
                    </div>
                    <div class="col">
                        <label>Hired At</label>
                        <input type="date" name="hired_at" class="form-control" value="{{ old('hired_at') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Salary</label>
                        <input type="number" name="salary" class="form-control" value="{{ old('salary') }}">
                    </div>
                    <div class="col">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Add Employee</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

