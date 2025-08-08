@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="text-dark">Dashboard</h1>
        </div>
    </div>

    <!-- Info Boxes -->
    <div class="row">
        <!-- Users Count -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $usersCount }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Employees Count -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $employeesCount }}</h3>
                    <p>Total Employees</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>

        <!-- Departments Count -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $departmentsCount }}</h3>
                    <p>Departments</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>

        <!-- Job Titles Count -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $jobTitlesCount }}</h3>
                    <p>Job Titles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-id-badge"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Pie Chart Example -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Employees by Department</h3>
                </div>
                <div class="card-body">
                    <canvas id="departmentChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart Example -->
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Monthly Hires</h3>
                </div>
                <div class="card-body">
                    <canvas id="hiresChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dummy data for departments chart
    const departmentChart = new Chart(document.getElementById('departmentChart'), {
        type: 'pie',
        data: {
            labels: ['IT', 'HR', 'Sales', 'Marketing'],
            datasets: [{
                data: [10, 5, 7, 3],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
            }]
        }
    });

    // Dummy data for hires chart
    const hiresChart = new Chart(document.getElementById('hiresChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr'],
            datasets: [{
                label: 'Hires',
                data: [2, 4, 3, 5],
                backgroundColor: '#17a2b8'
            }]
        }
    });
</script>
@endsection
