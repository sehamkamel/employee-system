@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">All Departments</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('departments.create') }}" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> Add Department
        </a>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Department Name</th>
                    <th>Description</th>
                    <th>Job Titles</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($departments as $department)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $department->name }}</td>
                        <td>{{ $department->description ?? '—' }}</td>
                        <td>
                            @if ($department->jobTitles && $department->jobTitles->count())
                                <ul class="list-unstyled mb-0">
                                    @foreach ($department->jobTitles as $jobTitle)
                                        <li class="mb-2">
                                            <strong>{{ $jobTitle->name }}</strong><br>
                                            <span class="text-muted" style="font-size: 0.875rem;">
                                                {{ $jobTitle->description ?? 'No description available.' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <em>No job titles</em>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash3"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No departments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
