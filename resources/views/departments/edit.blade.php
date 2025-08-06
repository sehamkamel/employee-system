@extends('layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Department</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('departments.update', $department->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Department Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $department->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $department->description) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update Department</button>
            </div>
        </form>
    </div>
@endsection
