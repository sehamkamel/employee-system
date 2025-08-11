@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Employee</h2>

    {{-- show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone">Phone Number</label>
            <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>

        <div class="mb-3">
            <label for="department-select">Department</label>
            <select id="department-select" name="department" class="form-control" required>
                <option value="">-- Select Department --</option>
                @foreach($departments as $d)
                    <option value="{{ $d['name'] }}" {{ old('department') == $d['name'] ? 'selected' : '' }}>
                        {{ $d['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="job-title-select">Job Title</label>
            <select id="job-title-select" name="job_title" class="form-control" required>
                <option value="">-- Select Job Title --</option>
                {{-- will be populated by JS based on chosen department --}}
            </select>
        </div>

        <div class="mb-3">
            <label for="hired_at">Hired Date</label>
            <input id="hired_at" type="date" name="hired_at" class="form-control" value="{{ old('hired_at') }}">
        </div>

        <div class="mb-3">
            <label for="salary">Salary</label>
            <input id="salary" type="number" name="salary" class="form-control" value="{{ old('salary') }}">
        </div>

        <div class="mb-3">
            <label for="address">Address</label>
            <textarea id="address" name="address" class="form-control">{{ old('address') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>

<div class="mt-3">
    <button type="submit" class="btn btn-success">Create</button>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
</div>

       
    </form>
</div>

<script>
    // departments array is passed from controller (array of {id,name,job_titles:[{id,name}]})
    const departments = {!! json_encode($departments) !!};
    const oldDepartment = {!! json_encode(old('department')) !!};
    const oldJobTitle = {!! json_encode(old('job_title')) !!};

    console.log("ttttttttttt",departments);
    

    const deptSelect = document.getElementById('department-select');
    const jobSelect = document.getElementById('job-title-select');

    function populateJobTitlesByDeptName(deptName) {
        jobSelect.innerHTML = '<option value="">-- Select Job Title --</option>';
        if (!deptName) return;
        const dept = departments.find(d => d.name === deptName);
        if (!dept || !dept.job_titles) return;
        dept.job_titles.forEach(j => {
            const opt = document.createElement('option');
            opt.value = j.name; // send name to match employees.job_title column
            opt.textContent = j.name;
            if (oldJobTitle && oldJobTitle === j.name) opt.selected = true;
            jobSelect.appendChild(opt);
        });
    }

    // on change
    deptSelect.addEventListener('change', function() {
        populateJobTitlesByDeptName(this.value);
    });

    // on load, if old values exist - populate
    document.addEventListener('DOMContentLoaded', function() {
        const useDept = oldDepartment || deptSelect.value;
        if (useDept) populateJobTitlesByDeptName(useDept);
    });
</script>
@endsection


