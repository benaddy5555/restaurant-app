<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Marina Fish Admin - {{ isset($title) ? $title : 'Dashboard' }}</title>
  <meta name="description" content="Marina Fish Admin Panel">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <!-- Admin CSS -->
  <style>
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 250px;
      background-color: #343a40;
      padding-top: 20px;
      z-index: 1000;
    }
    
    .main-content {
      margin-left: 250px;
      padding: 20px;
      min-height: 100vh;
      background-color: #f8f9fa;
    }
    
    .sidebar .nav-link {
      color: #adb5bd;
      padding: 10px 20px;
      display: block;
      text-decoration: none;
      border-radius: 5px;
      margin-bottom: 5px;
    }
    
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #495057;
      color: white;
    }
    
    .sidebar .nav-link i {
      margin-right: 10px;
    }
    
    .card {
      border: none;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .btn-sm {
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
    }
    
    /* Enhanced Action Buttons */
    .action-btn {
      position: relative;
      padding: 0.375rem 0.75rem;
      font-size: 0.8rem;
      font-weight: 500;
      border-radius: 0.375rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 1.5px solid;
      display: inline-flex;
      align-items: center;
      gap: 0.375rem;
      min-width: 80px;
      justify-content: center;
      text-decoration: none;
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.05);
    }
    
    .action-btn i {
      font-size: 0.9rem;
      transition: transform 0.2s ease;
    }
    
    .action-btn .btn-text {
      font-family: 'Roboto', sans-serif;
      font-weight: 500;
    }
    
    /* View Button - Info Style */
    .action-btn.btn-outline-info {
      border-color: #17a2b8;
      color: #17a2b8;
      background: rgba(23, 162, 184, 0.1);
    }
    
    .action-btn.btn-outline-info:hover {
      background: #17a2b8;
      color: white;
      border-color: #17a2b8;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    }
    
    .action-btn.btn-outline-info:hover i {
      transform: scale(1.1);
    }
    
    /* Edit Button - Warning Style (matching site accent) */
    .action-btn.btn-outline-warning {
      border-color: #cda45e;
      color: #cda45e;
      background: rgba(205, 164, 94, 0.1);
    }
    
    .action-btn.btn-outline-warning:hover {
      background: #cda45e;
      color: #0c0b09;
      border-color: #cda45e;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(205, 164, 94, 0.3);
    }
    
    .action-btn.btn-outline-warning:hover i {
      transform: scale(1.1);
    }
    
    /* Delete Button - Danger Style */
    .action-btn.btn-outline-danger {
      border-color: #dc3545;
      color: #dc3545;
      background: rgba(220, 53, 69, 0.1);
    }
    
    .action-btn.btn-outline-danger:hover {
      background: #dc3545;
      color: white;
      border-color: #dc3545;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
    
    .action-btn.btn-outline-danger:hover i {
      transform: scale(1.1);
    }
    
    /* Button Group Styling */
    .btn-group {
      display: flex;
      gap: 0.5rem;
      flex-wrap: nowrap;
      align-items: center;
    }
    
    .btn-group .action-btn {
      flex: 1;
    }
    
    .btn-group .action-btn + .action-btn {
      margin-left: 0;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .action-btn .btn-text {
        display: none;
      }
      
      .action-btn {
        min-width: auto;
        padding: 0.5rem;
        justify-content: center;
      }
      
      .btn-group {
        gap: 0.25rem;
      }
    }
    
    @media (max-width: 576px) {
      .action-btn {
        padding: 0.375rem;
        font-size: 0.75rem;
      }
      
      .action-btn i {
        font-size: 0.8rem;
      }
    }
    
    /* Tooltip Enhancement */
    .tooltip {
      font-size: 0.75rem;
      font-weight: 500;
    }
    
    /* Focus States */
    .action-btn:focus {
      outline: none;
      box-shadow: 0 0 0 0.2rem rgba(205, 164, 94, 0.25);
    }
    
    .action-btn.btn-outline-info:focus {
      box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
    }
    
    .action-btn.btn-outline-danger:focus {
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s;
      }
      
      .main-content {
        margin-left: 0;
      }
      
      .sidebar.show {
        transform: translateX(0);
      }
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="text-center mb-4">
      <h4 class="text-white">Marina Fish</h4>
      <small class="text-muted">Admin Panel</small>
    </div>
    
    <nav class="nav flex-column">
      <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      
      <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
        <i class="bi bi-box"></i> Products
      </a>
      
      <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        <i class="bi bi-cart-check"></i> Orders
      </a>
      
      <div class="nav-link">
        <i class="bi bi-person"></i> {{ auth()->user()->name }}
      </div>
      
      <a href="{{ route('home') }}" class="nav-link">
        <i class="bi bi-house"></i> Back to Site
      </a>
      
      <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="nav-link" style="background: none; border: none; text-align: left; width: 100%;">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Flash Messages -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Page Header -->
    @if(isset($header))
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">{{ $header }}</h2>
        @isset($actions)
          <div>{{ $actions }}</div>
        @endisset
      </div>
    @endif

    <!-- Page Content -->
    @yield('content')
  </div>

  <!-- Mobile Toggle -->
  <button class="btn btn-primary d-md-none" style="position: fixed; top: 20px; left: 20px; z-index: 1001;" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
  </button>

  <!-- Bootstrap JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('show');
    }
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  </script>
</body>

</html>
