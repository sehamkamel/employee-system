@extends('layout')

@section('content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Departments</h2>
    <a href="{{ route('departments.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
      <i class="bi bi-plus-lg"></i> Add Department
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="row g-4">
    @forelse($departments as $d)
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-2">{{ $d->name }}</h5>
            <p class="card-text text-muted mb-3">{{ $d->description ?? '—' }}</p>

            @php
              // إذا القسم "Software Development"، نُظهر أول 3 مسميات فقط
              $titles = $d->name === 'Software Development'
                        ? $d->jobTitles->take(3)
                        : $d->jobTitles;
            @endphp

            @if($titles->isNotEmpty())
              <ul class="list-unstyled small mb-3 ps-3">
                @foreach($titles as $j)
                  <li class="mb-1">
                    <strong>{{ $j->name }}</strong><br>
                    <small class="text-muted">{{ $j->description }}</small>
                  </li>
                @endforeach
                @if($d->name === 'Software Development' && $d->jobTitles->count() > 3)
                  <li class="text-center">
                    <small class="text-primary">...and {{ $d->jobTitles->count() - 3 }} more</small>
                  </li>
                @endif
              </ul>
            @else
              <p class="text-muted small mb-3">No job titles</p>
            @endif

            <div class="mt-auto d-flex justify-content-between">
              <a href="{{ route('departments.edit', $d->id) }}"
                 class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                <i class="bi bi-pencil"></i> Edit
              </a>
              <form action="{{ route('departments.destroy', $d->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this department?')"
                    class="m-0 p-0">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </form>
            </div>

          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center text-muted py-5">
        <i class="bi bi-info-circle fs-1 mb-2"></i>
        <p>No departments found.</p>
      </div>
    @endforelse
  </div>
</div>
@endsection
