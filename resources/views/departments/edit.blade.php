@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">Edit Department</h3>
        </div>
        <form action="{{ route('departments.update', $department->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Department Name</label>
                    <input type="text" name="name" id="name" 
                           class="form-control" 
                           value="{{ old('name', $department->name) }}" 
                           placeholder="Enter department name" required>
                </div>

                <div class="form-group mt-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" 
                              class="form-control" 
                              placeholder="Enter description" rows="3">{{ old('description', $department->description) }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-warning">Update Department</button>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
