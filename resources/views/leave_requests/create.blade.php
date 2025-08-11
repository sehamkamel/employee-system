@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 650px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 d-flex align-items-center gap-2">
            <i class="bi bi-calendar-plus fs-4"></i>
            <h4 class="mb-0">Request New Leave</h4>
        </div>

        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
            @endif

            <form action="{{ route('leave-requests.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="leave_type" class="form-label fw-bold">Leave Type</label>
                    <input
                        type="text"
                        class="form-control rounded-3 @error('leave_type') is-invalid @enderror"
                        id="leave_type"
                        name="leave_type"
                        value="{{ old('leave_type') }}"
                        placeholder="Enter leave type"
                    >
                    @error('leave_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label fw-bold">Start Date</label>
                        <input
                            type="date"
                            class="form-control rounded-3 @error('start_date') is-invalid @enderror"
                            id="start_date"
                            name="start_date"
                            value="{{ old('start_date') }}"
                        >
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label fw-bold">End Date</label>
                        <input
                            type="date"
                            class="form-control rounded-3 @error('end_date') is-invalid @enderror"
                            id="end_date"
                            name="end_date"
                            value="{{ old('end_date') }}"
                        >
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label fw-bold">Reason</label>
                    <textarea
                        class="form-control rounded-3 @error('reason') is-invalid @enderror"
                        id="reason"
                        name="reason"
                        rows="4"
                        placeholder="Optional reason for your leave"
                    >{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" 
                            class="btn btn-primary flex-fill d-inline-flex align-items-center justify-content-center gap-2 rounded-3 shadow-sm"
                            style="transition: transform 0.2s ease-in-out;"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <i class="bi bi-send"></i> Submit Request
                    </button>
                    <a href="{{ route('leave-requests.index') }}" 
                       class="btn btn-outline-secondary flex-fill d-inline-flex align-items-center justify-content-center gap-2 rounded-3 shadow-sm"
                       style="transition: transform 0.2s ease-in-out;"
                       onmouseover="this.style.transform='scale(1.05)'"
                       onmouseout="this.style.transform='scale(1)'">
                        <i class="bi bi-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
