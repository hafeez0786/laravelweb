@extends('user.layout')

@section('page_title', 'User Dashboard')

@section('user_content')
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stats-card">
                <div class="stats-icon primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3 class="mb-2">{{ $stats['total_orders'] ?? 0 }}</h3>
                <p class="text-muted mb-0">Total Orders</p>
                <small class="text-success"><i class="fas fa-arrow-up me-1"></i>12% from last month</small>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stats-card">
                <div class="stats-icon success">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <h3 class="mb-2">{{ $stats['active_projects'] ?? 0 }}</h3>
                <p class="text-muted mb-0">Active Projects</p>
                <small class="text-info"><i class="fas fa-minus me-1"></i>Same as last week</small>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stats-card">
                <div class="stats-icon info">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3 class="mb-2">{{ $stats['unread_messages'] ?? 0 }}</h3>
                <p class="text-muted mb-0">Unread Messages</p>
                <small class="text-warning"><i class="fas fa-arrow-down me-1"></i>8% from yesterday</small>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="stats-card">
                <div class="stats-icon warning">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3 class="mb-2">{{ $stats['profile_completion'] ?? 85 }}%</h3>
                <p class="text-muted mb-0">Profile Complete</p>
                <small class="text-success"><i class="fas fa-check me-1"></i>Good progress</small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0 text-gray-800">
                        <i class="fas fa-bolt me-2 text-primary"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <!-- New Task Button -->
                        @if(auth()->user()->hasPermission('create_tasks'))
                        <a href="#" class="btn btn-outline-primary btn-lg text-start" onclick="alert('Task creation will be implemented soon!'); return false;">
                            <i class="fas fa-plus-circle me-2"></i> New Task
                        </a>
                        @endif
                        
                        <!-- Upload Files Button -->
                        @if(auth()->user()->hasPermission('upload_files'))
                        <a href="#" class="btn btn-outline-success btn-lg text-start" onclick="alert('File upload will be implemented soon!'); return false;">
                            <i class="fas fa-upload me-2"></i> Upload Files
                        </a>
                        @endif
                        
                        <!-- View Reports Button -->
                        @if(auth()->user()->hasPermission('view_reports'))
                        <a href="#" class="btn btn-outline-info btn-lg text-start" onclick="alert('Reports will be available soon!'); return false;">
                            <i class="fas fa-chart-bar me-2"></i> View Reports
                        </a>
                        @endif
                        
                        <!-- Account Settings Button -->
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-warning btn-lg text-start">
                            <i class="fas fa-cog me-2"></i> Account Settings
                        </a>
                    </div>
                    
                    <!-- Profile Completion -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">Profile Completion</small>
                            <small class="text-muted">{{ $stats['profile_completion'] ?? 85 }}%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-gradient" role="progressbar" style="width: {{ $stats['profile_completion'] ?? 85 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0 text-gray-800">
                        <i class="fas fa-history me-2 text-primary"></i>Recent Activity
                    </h6>
                </div>
                <div class="card-body">
                    @forelse($activities ?? [] as $activity)
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle p-2 me-3">
                            <i class="fas {{ $activity['icon'] ?? 'fa-circle' }} text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">{{ $activity['title'] ?? 'Activity' }}</h6>
                            <small class="text-muted">{{ $activity['description'] ?? 'No description available' }}</small>
                        </div>
                        <small class="text-muted">{{ $activity['time'] ?? 'Just now' }}</small>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-inbox display-4 text-muted mb-3"></i>
                        <p class="text-muted mb-0">No recent activity</p>
                        <small class="text-muted">Your activities will appear here</small>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section (only show if user has permission) -->
    @if(auth()->user()->hasPermission('view_products'))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-gray-800">
                        <i class="fas fa-box me-2 text-primary"></i>Featured Products
                    </h6>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-gradient">View All</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=300&fit=crop&crop=center&auto=format" class="card-img-top" alt="Premium Laptop" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">Premium Laptop</h6>
                                    <p class="card-text text-muted">High-performance laptop for professionals</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-primary mb-0">$1,299</span>
                                        <button class="btn btn-sm btn-gradient">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <img src="https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&h=300&fit=crop&crop=center&auto=format" class="card-img-top" alt="Wireless Mouse" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">Wireless Mouse</h6>
                                    <p class="card-text text-muted">Ergonomic wireless mouse with precision tracking</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-primary mb-0">$29.99</span>
                                        <button class="btn btn-sm btn-gradient">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <img src="https://images.unsplash.com/photo-1587829741341-e3a3f11a1a64?w=400&h=300&fit=crop&crop=center&auto=format" class="card-img-top" alt="Mechanical Keyboard" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">Mechanical Keyboard</h6>
                                    <p class="card-text text-muted">Premium mechanical keyboard with RGB lighting</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-primary mb-0">$149.99</span>
                                        <button class="btn btn-sm btn-gradient">View Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
