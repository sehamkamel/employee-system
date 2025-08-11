@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Departments</h1>
     <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('departments.create') }}" class="btn btn-success">+Add Department</a>
    </div>

    @foreach ($departments as $department)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">{{ $department->name }}</h5>
                    <small class="text-muted">{{ $department->description }}</small>
                </div>
                <div>
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-warning">Edit</a>
                 <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
</form>

                </div>
            </div>
            <div class="card-body">
         <strong>Job Titles:</strong>
@if ($department->jobTitles->count())
    <ul class="list-group mt-2">
        @foreach ($department->jobTitles as $job)
 <li class="list-group-item">{{ $job->name }}</li>


        @endforeach
    </ul>
@else
    <p class="text-muted">No job titles available.</p>
@endif

            </div>
        </div>
    @endforeach

</div>
@endsection


