@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">📅 Leave Requests</h1>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    {{-- زرار إضافة طلب جديد للموظفين فقط --}}
    @if(auth()->user()->role === 'employee')
        <a href="{{ route('leave-requests.create') }}" 
           class="btn btn-primary mb-3 shadow-sm d-inline-flex align-items-center gap-2"
           style="transition: transform 0.2s ease-in-out;"
           onmouseover="this.style.transform='scale(1.05)'" 
           onmouseout="this.style.transform='scale(1)'">
            <i class="bi bi-plus-circle"></i> Add New Leave Request
        </a>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Dates</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaveRequests as $request)
                    <tr>
                        <td>{{ $request->employee->name }}</td>
                        <td>{{ $request->leave_type }}</td>
                        <td>{{ $request->start_date }} → {{ $request->end_date }}</td>
                        <td>{{ $request->reason ?? '-' }}</td>
                        <td>
                            @if($request->status === 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($request->status === 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                {{-- لو HR --}}
                                @if(auth()->user()->role === 'hr' && $request->status === 'Pending')
                                    <form action="{{ route('leave-requests.updateStatus', ['id' => $request->id, 'status' => 'Approved']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm shadow-sm">
                                            ✅ Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('leave-requests.updateStatus', ['id' => $request->id, 'status' => 'Rejected']) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                            ❌ Reject
                                        </button>
                                    </form>
                                @endif

                                {{-- لو موظف --}}
                                @if(auth()->user()->role === 'employee' && $request->status === 'Pending')
                                    <form action="{{ route('leave-requests.destroy', $request->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline-danger btn-sm shadow-sm"
                                                onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                            🗑 Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
