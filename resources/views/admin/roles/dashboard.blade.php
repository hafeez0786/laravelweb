@extends('admin.layout')

@section('page_title', 'Roles Dashboard')

@section('admin_content')
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Normal Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Admin Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $adminCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Admin Ratio
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalUsers > 0 ? round(($adminCount / $totalUsers) * 100, 1) : 0 }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="row">
        <!-- Role Distribution Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Role Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="rolePieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Normal Users
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Admin Users
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Role Changes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Role Changes</h6>
                </div>
                <div class="card-body">
                    @if($recentRoleChanges->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRoleChanges as $change)
                                        <tr>
                                            <td>
                                                <div>{{ $change->name }}</div>
                                                <small class="text-muted">{{ $change->email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $change->role === 'admin' ? 'danger' : 'success' }}">
                                                    {{ ucfirst($change->role) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $change->updated_at->diffForHumans() }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted">No recent role changes found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-3">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-primary btn-circle btn-lg mb-2">
                                <i class="fas fa-list"></i>
                            </a>
                            <br>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-primary">View All Roles</a>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-success btn-circle btn-lg mb-2">
                                <i class="fas fa-users"></i>
                            </a>
                            <br>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-success">Manage Users</a>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-info btn-circle btn-lg mb-2">
                                <i class="fas fa-shield-alt"></i>
                            </a>
                            <br>
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-outline-info">Permissions</a>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-warning btn-circle btn-lg mb-2">
                                <i class="fas fa-user-plus"></i>
                            </a>
                            <br>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-outline-warning">Add User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pie Chart
    var ctx = document.getElementById("rolePieChart");
    var rolePieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Normal Users", "Admin Users"],
            datasets: [{
                data: [{{ $userCount }}, {{ $adminCount }}],
                backgroundColor: ['#1cc88a', '#e74a3b'],
                hoverBackgroundColor: ['#17a673', '#c0392b'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
</script>
@endpush
