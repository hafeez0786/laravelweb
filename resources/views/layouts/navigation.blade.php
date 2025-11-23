<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ auth()->user() && auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            @auth
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Admin Dashboard
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users me-1"></i> Users
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                                <i class="fas fa-user-cog me-1"></i> Roles
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">
                                <i class="fas fa-shield-alt me-1"></i> Permissions
                            </a>
                        </li>
                    @else
                        <!-- Regular users only see features they have permission for -->
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                                <i class="fas fa-home me-1"></i> My Dashboard
                            </a>
                        </li>
                        
                        <!-- Products navigation menu - only show if user has permission -->
                        @if(auth()->user()->hasPermission('view_products'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    <i class="fas fa-box me-1"></i> Products
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user me-1"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.querySelector('form[action=\"{{ route('logout') }}\"]').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i> Log Out
                            </a>
                        </div>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
