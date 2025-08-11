@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Attendance Page</h2>

    {{-- عرض رسائل الفلاش --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card p-4 mb-4">
        <form method="POST" action="{{ route('attendance.checkin') }}">
            @csrf
            <button type="submit" class="btn btn-success w-100">Check In</button>
        </form>
    </div>

    <div class="card p-4">
        <form method="POST" action="{{ route('attendance.checkout') }}">
            @csrf
            <button type="submit" class="btn btn-warning w-100">Check Out</button>
        </form>
    </div>
</div>
@endsection


