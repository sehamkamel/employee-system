@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Attendance Page</h2>


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

