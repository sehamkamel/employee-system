@extends('layouts.app')
@section('content')

<div class="container py-3">
    <h2 class="mb-3">Dashboard Overview</h2>

    @php
    $cards = [
        [
            'label' => 'Total Users',
            'icon' => 'fas fa-users',
            'count' => $usersCount,
            'bg_color' => 'bg-primary',
        ],
        [
            'label' => 'Total Employees',
            'icon' => 'fas fa-user-tie',
            'count' => $employeesCount,
            'bg_color' => 'bg-success',
        ],
        [
            'label' => 'Departments',
            'icon' => 'fas fa-building',
            'count' => $departmentsCount,
            'bg_color' => 'bg-warning',
        ],
        [
            'label' => 'Job Titles',
            'icon' => 'fas fa-id-badge',
            'count' => $jobTitlesCount,
            'bg_color' => 'bg-danger',
        ],
    ];
    @endphp

    <div class="row g-4 mb-5">
        @foreach ($cards as $card)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card text-white {{ $card['bg_color'] }} shadow-sm rounded-4" style="min-height: 160px; border: none;">
                    <div class="card-body d-flex align-items-center">
                        <i class="{{ $card['icon'] }} fa-3x me-4 opacity-75"></i>
                        <div>
                            <h2 class="mb-1 fw-bold">{{ $card['count'] }}</h2>
                            <p class="mb-0 fw-semibold">{{ $card['label'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ApexCharts Bar Chart --}}
    <h2 class="mb-4">System Data Chart</h2>
    <div id="chart"></div>
</div>

{{-- تحميل مكتبة ApexCharts --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var options = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        series: [{
            name: 'Count',
            data: [{{ $usersCount }}, {{ $employeesCount }}, {{ $departmentsCount }}, {{ $jobTitlesCount }}]
        }],
        xaxis: {
            categories: ['Users', 'Employees', 'Departments', 'Job Titles'],
            labels: {
                style: { fontSize: '14px', fontWeight: '600', colors: ['#007bff', '#28a745', '#ffc107', '#dc3545'] }
            }
        },
        colors: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
        dataLabels: { enabled: true },
        plotOptions: { bar: { borderRadius: 6 } }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
});
</script>
@endsection






