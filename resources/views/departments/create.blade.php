@extends('layout')

@section('title', 'Add Department')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Department</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Department Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
                <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" class="form-control" id="description" rows="3"></textarea>
</div>

            </form>
        </div>
    </div>
@endsection
