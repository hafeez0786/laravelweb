<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - User Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .user-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: white;
            padding: 0;
            z-index: 1000;
            box-shadow: 2px 0 20px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 30px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
        }
        
        .sidebar-header .user-avatar {
            width: 80px;
            height: 80px;
            background: white;
            color: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2rem;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .sidebar-header h4 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .sidebar-header .role-badge {
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-top: 5px;
            display: inline-block;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar .nav-link {
            color: #5a5c69;
            padding: 15px 25px;
            margin: 2px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        
        .sidebar .nav-link:hover {
            background: #f8f9fc;
            color: #667eea;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .sidebar .nav-link i {
            width: 25px;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: #f8f9fc;
        }
        
        .top-header {
            background: white;
            padding: 20px 40px;
            border-bottom: 1px solid #e3e6f0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .top-header .btn-link {
            color: #5a5c69;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .top-header .btn-link:hover {
            background: #f8f9fc;
            color: #667eea;
            transform: translateY(-1px);
        }
        
        .top-header .btn-link:focus {
            box-shadow: none;
        }
        
        .top-header .dropdown-toggle::after {
            display: none;
        }
        
        .notification-badge {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 18px;
            height: 18px;
            background: #f56565;
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid white;
        }
        
        .user-avatar-small {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }
        
        .user-avatar-small:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 8px;
            margin-top: 8px;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 10px 16px;
            margin: 2px 0;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: #f8f9fc;
            color: #667eea;
            transform: translateX(2px);
        }
        
        .dropdown-item i {
            width: 20px;
            text-align: center;
        }
        
        .dropdown-divider {
            margin: 8px 0;
            border-color: #e3e6f0;
        }
        
        .content-wrapper {
            padding: 30px 40px;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            position: relative;
            overflow: hidden;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            transform: translate(30px, -30px);
            opacity: 0.1;
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        
        .stats-icon.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .stats-icon.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }
        
        .stats-icon.info {
            background: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
            color: white;
        }
        
        .stats-icon.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        @media (max-width: 768px) {
            .user-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .user-sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content-wrapper {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- User Sidebar -->
    <nav class="user-sidebar">
        <div class="sidebar-header">
            <div class="user-avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <h4>{{ auth()->user()->name }}</h4>
            <div class="role-badge">
                <i class="fas fa-user me-1"></i> {{ ucfirst(auth()->user()->role) }}
            </div>
        </div>
        
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" 
                       href="{{ route('user.dashboard') }}">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </li>
                
                <!-- Products navigation menu - only show if user has permission -->
                @if(auth()->user()->hasPermission('view_products'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" 
                       href="{{ route('products.index') }}">
                        <i class="fas fa-box"></i>
                        Products
                    </a>
                </li>
                @endif
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-cog"></i>
                        Profile Settings
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-outline-secondary btn-sm me-3 d-lg-none" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="mb-0 text-gray-800">@yield('page_title', 'User Dashboard')</h4>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown me-3">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell text-gray-600"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-shopping-cart me-2"></i>New order received
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i>Profile updated
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>System maintenance
                            </a>
                            <hr>
                            <a class="dropdown-item text-center" href="#">View all notifications</a>
                        </div>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <div class="user-avatar-small me-2">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="text-gray-700 me-1">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-600"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user me-2"></i> Profile Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Page Content -->
        <div class="content-wrapper">
            @yield('user_content')
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Modal Fix Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtn = document.querySelector('[data-bs-target="#confirmUserDeletion"]');
            const modal = document.getElementById('confirmUserDeletion');
            
            if (deleteBtn && modal) {
                deleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Store current scroll position
                    const scrollY = window.scrollY;
                    
                    // Disable scrolling
                    document.body.style.position = 'fixed';
                    document.body.style.top = `-${scrollY}px`;
                    document.body.style.width = '100%';
                    document.body.style.overflow = 'hidden';
                    
                    // Show modal
                    modal.style.display = 'block';
                    modal.classList.add('show');
                    document.body.classList.add('modal-open');
                    
                    // Add backdrop
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    backdrop.id = 'modal-backdrop';
                    document.body.appendChild(backdrop);
                    
                    // Store scroll position for restoration
                    modal.dataset.scrollY = scrollY;
                });
                
                // Close modal functions
                function closeModal() {
                    // Restore scroll position
                    const scrollY = modal.dataset.scrollY || 0;
                    document.body.style.position = '';
                    document.body.style.top = '';
                    document.body.style.width = '';
                    document.body.style.overflow = '';
                    window.scrollTo(0, parseInt(scrollY));
                    
                    // Hide modal
                    modal.style.display = 'none';
                    modal.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    
                    // Remove backdrop
                    const backdrop = document.getElementById('modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                }
                
                // Close on X button
                const closeBtn = modal.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', closeModal);
                }
                
                // Close on cancel button
                const cancelBtn = modal.querySelector('[data-bs-dismiss="modal"]');
                if (cancelBtn) {
                    cancelBtn.addEventListener('click', closeModal);
                }
                
                // Close on backdrop click
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
                
                // Close on ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && modal.classList.contains('show')) {
                        closeModal();
                    }
                });
            }
        });
    </script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.user-sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>
