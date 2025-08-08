<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Management</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark bg-navy">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item">
          @auth
            <a class="nav-link" href="{{ route('dashboard') }}">Home</a>
          @else
            <a class="nav-link" href="{{ route('login') }}">Home</a>
          @endauth
        </li>
      </ul>

      @auth
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn btn-outline-light logout-btn">
                Logout
              </button>
            </form>
          </li>
        </ul>
      @endauth
    </div>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-navy elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <div class="sidebar">
      @auth
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

            {{-- Dashboard - للجميع --}}
            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>

            {{-- Admin & HR --}}
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'hr')
              {{-- Employees --}}
              <li class="nav-item">
                @if(Route::has('employees.index'))
                  <a href="{{ route('employees.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Employees</p>
                  </a>
                @else
                  <a href="#" class="nav-link disabled">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Employees</p>
                  </a>
                @endif
              </li>

              {{-- Departments --}}
              <li class="nav-item">
                @if(Route::has('departments.index'))
                  <a href="{{ route('departments.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-building"></i>
                    <p>Departments</p>
                  </a>
                @else
                  <a href="#" class="nav-link disabled">
                    <i class="nav-icon fas fa-building"></i>
                    <p>Departments </p>
                  </a>
                @endif
              </li>

              {{-- Attendance --}}
              <li class="nav-item">
                @if(Route::has('admin.attendance.index'))
                  <a href="{{ route('admin.attendance.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-calendar-check"></i>
                    <p>Attendance</p>
                  </a>
                @else
                  <a href="#" class="nav-link disabled">
                    <i class="nav-icon fas fa-calendar-check"></i>
                    <p>Attendance</p>
                  </a>
                @endif
              </li>
            @endif

            {{-- Employee فقط --}}
            @if(auth()->user()->role === 'employee')
              {{-- Attendance --}}
              <li class="nav-item">
                @if(Route::has('attendance.index'))
                  <a href="{{ route('attendance.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-calendar-check"></i>
                    <p>Attendance</p>
                  </a>
                @else
                  <a href="#" class="nav-link disabled">
                    <i class="nav-icon fas fa-calendar-check"></i>
                    <p>Attendance </p>
                  </a>
                @endif
              </li>

              {{-- Leaves --}}
              <li class="nav-item">
                @if(Route::has('leaves.index'))
                  <a href="{{ route('leaves.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-calendar-minus"></i>
                    <p>Leaves</p>
                  </a>
                @else
                  <a href="#" class="nav-link disabled">
                    <i class="nav-icon fas fa-calendar-minus"></i>
                    <p>Leaves (coming soon)</p>
                  </a>
                @endif
              </li>
            @endif

          </ul>
        </nav>
      @endauth
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('title')</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
    <div class="container-fluid">

        {{-- Flash Message --}}
        @if(session('success'))
            <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

      

        @yield('content')

    </div>
</section>


   
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2025 <a href="#">Your Company</a>.</strong>
    All rights reserved.
  </footer>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // يخلي الرسالة تختفي بعد 3 ثواني
    setTimeout(function () {
        const flash = document.getElementById('flash-message');
        if (flash) {
            flash.style.transition = 'opacity 0.5s ease';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500); // نشيلها نهائيًا
        }
    }, 3000); // 3 ثواني
</script>


</body>
</html>
