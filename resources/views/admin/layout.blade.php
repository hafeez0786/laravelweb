<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 0;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 20px;
            background: rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .sidebar-header h3 {
            color: white;
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 2px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            font-weight: 500;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        
        .sidebar-heading {
            color: rgba(255,255,255,0.6);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 10px 20px;
            margin: 20px 0 10px 0;
            letter-spacing: 0.5px;
        }
        
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background: #f8f9fa;
        }
        
        .top-header {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e3e6f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown .dropdown-toggle {
            background: none;
            border: none;
            color: #5a5c69;
            font-weight: 500;
        }
        
        .user-dropdown .dropdown-toggle:hover {
            color: #4e73df;
        }
        
        .content-wrapper {
            padding: 30px;
        }
        
        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        
        .btn-circle {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-shield-alt me-2"></i>Admin Panel</h3>
        </div>
        
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                
                <div class="sidebar-heading">User Management</div>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                       href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
                
                <div class="sidebar-heading">Roles & Permissions</div>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" 
                       href="{{ route('admin.roles.index') }}">
                        <i class="fas fa-user-cog"></i>
                        Manage Roles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" 
                       href="{{ route('admin.permissions.index') }}">
                        <i class="fas fa-shield-alt"></i>
                        Permissions
                    </a>
                </li>
                
                <div class="sidebar-heading">System</div>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.dashboard') }}">
                        <i class="fas fa-home"></i>
                        User Dashboard
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- User Info at Bottom -->
        <div class="position-absolute bottom-0 w-100 p-3">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
                   id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 32px; height: 32px; font-weight: bold;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="ms-2">
                        <div class="small fw-bold">{{ auth()->user()->name }}</div>
                        <div class="small text-white-50">Administrator</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user me-2"></i>Profile
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Sign out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-gray-800">@yield('page_title', 'Admin Panel')</h4>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell text-gray-600"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">No new notifications</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Page Content -->
        <div class="content-wrapper">
            @yield('admin_content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>
