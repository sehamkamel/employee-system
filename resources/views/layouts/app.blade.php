<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Employee Management</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css" />
  <style>
    body.dark-mode {
      background-color: #121212 !important;
      color: #e0e0e0 !important;
    }
    body.dark-mode .main-header,
    body.dark-mode .main-sidebar,
    body.dark-mode .content-wrapper,
    body.dark-mode .main-footer {
      background-color: #1e1e1e !important;
      color: #e0e0e0 !important;
    }
    body.dark-mode .nav-link,
    body.dark-mode .brand-link,
    body.dark-mode .btn-outline-light {
      color: #ccc !important;
    }
    body.dark-mode .btn-outline-light:hover {
      background-color: #444 !important;
      color: #fff !important;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark bg-navy">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

    <div class="container-fluid d-flex align-items-center">
      <ul class="navbar-nav">
        <li class="nav-item">
          @auth
            <a class="nav-link" href="{{ route('dashboard') }}">Home</a>
          @else
            <a class="nav-link" href="{{ route('login') }}">Home</a>
          @endauth
        </li>
      </ul>

      <!-- Dark Mode Toggle Button -->
      <button id="darkModeToggle" class="btn btn-outline-light ml-auto me-3" type="button" style="white-space: nowrap;">
        🌙 Dark Mode
      </button>

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
        @endif

        {{-- Leave Requests للجميع (admin, hr, employee) --}}
        @if(in_array(auth()->user()->role, ['admin', 'hr', 'employee']))
          <li class="nav-item">
            @if(Route::has('leave-requests.index'))
              <a href="{{ route('leave-requests.index') }}" class="nav-link">
                <i class="nav-icon fas fa-calendar-minus"></i>
                <p>Leaves</p>
              </a>
            @else
              <a href="#" class="nav-link disabled">
                <i class="nav-icon fas fa-calendar-minus"></i>
                <p>Leaves</p>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<script>
  // يخلي الرسالة تختفي بعد 3 ثواني
  setTimeout(function () {
    const flash = document.getElementById('flash-message');
    if (flash) {
      flash.style.transition = 'opacity 0.5s ease';
      flash.style.opacity = '0';
      setTimeout(() => flash.remove(), 500); // نشيلها نهائيًا
    }
  }, 3000);

  // Dark Mode Toggle logic
  const toggleBtn = document.getElementById('darkModeToggle');
  const body = document.body;

  function applyDarkMode(enabled) {
    if (enabled) {
      body.classList.add('dark-mode');
      toggleBtn.textContent = '☀️ Light Mode';
    } else {
      body.classList.remove('dark-mode');
      toggleBtn.textContent = '🌙 Dark Mode';
    }
  }

  // تفعيل وضع الداكن بناء على localStorage
  if(localStorage.getItem('darkMode') === 'enabled') {
    applyDarkMode(true);
  }

  toggleBtn.addEventListener('click', () => {
    const enabled = body.classList.contains('dark-mode');
    if (enabled) {
      applyDarkMode(false);
      localStorage.setItem('darkMode', 'disabled');
    } else {
      applyDarkMode(true);
      localStorage.setItem('darkMode', 'enabled');
    }
  });
</script>

</body>
</html>
