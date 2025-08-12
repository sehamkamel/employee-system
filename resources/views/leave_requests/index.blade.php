@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">📅 Leave Requests</h1>


    {{-- زرار إضافة طلب جديد للموظفين فقط --}}
    @if(auth()->user()->role === 'employee')
         <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('leave-requests.create') }}" class="btn btn-success">+ Add New Leave Request</a>
    </div>

    @endif

  
   <style>
    /* منع تكسير الكلام في الجدول */
    .table td, .table th {
        white-space: nowrap;
        vertical-align: middle;
    }

    /* تصغير حجم النص في الجدول */
    .table td {
        font-size: 14px;
    }

    /* تحسين الأزرار */
    .btn {
        transition: all 0.2s ease-in-out;
    }
    .btn:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }
</style>

<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-light">
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
                            @if(in_array(auth()->user()->role, ['hr', 'admin']) && $request->status === 'Pending')
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
                                            >
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
