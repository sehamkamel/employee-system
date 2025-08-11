@extends('layouts.app')
   @section('content')

<div class="container py-3">
      <h2 class="mb-3 ">Dashboard Overview</h2>
   
      
    @php
    $cards = [
        [
            'label' => 'Total Users',
            'icon' => 'fas fa-users',
            'count' => $usersCount,
            'bg_gradient' => 'background: linear-gradient(135deg, #1e3c72 0%, #99f2c8  100%);',
            'icon_color' => '#cbd5e1' // لون فاتح كحلي
        ],
        [
            'label' => 'Total Employees',
            'icon' => 'fas fa-user-tie',
            'count' => $employeesCount,
            'bg_gradient' => 'background: linear-gradient(135deg, #1e3c72 0%, #99f2c8  100%);',
            'icon_color' => '#a8dadc'
        ],
        [
            'label' => 'Departments',
            'icon' => 'fas fa-building',
            'count' => $departmentsCount,
            'bg_gradient' => 'background: linear-gradient(135deg, #1e3c72 0%, #99f2c8 100%);',
            'icon_color' => '#f1faee'
        ],
        [
            'label' => 'Job Titles',
            'icon' => 'fas fa-id-badge',
            'count' => $jobTitlesCount,
            'bg_gradient' => 'background: linear-gradient(135deg, #1e3c72 0%, #99f2c8 100%);',
            'icon_color' => '#264653'
        ],
    ];
    @endphp

    <div class="row g-4 mb-5">
        @foreach ($cards as $card)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card shadow rounded-5 text-white" style="min-height: 180px; {{ $card['bg_gradient'] }} border: none;">
                    <div class="card-body d-flex align-items-center">
                        <i class="{{ $card['icon'] }} fa-4x me-4" style="color: {{ $card['icon_color'] }}"></i>
                        <div>
                            <h2 class="mb-2 fw-bold" style="font-size: 3rem;">{{ $card['count'] }}</h2>
                            <p class="mb-0 fs-5 fw-semibold">{{ $card['label'] }}</p>
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
                style: { fontSize: '14px', fontWeight: 'bold', colors: ['#1e3c72', '#16222a', '#283e51', '#1f4037'] }
            }
        },
        colors: ['#1e3c72', '#16222a', '#283e51', '#1f4037'],
        dataLabels: { enabled: true },
        plotOptions: { bar: { borderRadius: 6 } }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
});
</script>
@endsection





