@extends('admin.layout')

@section('page_title', 'Roles Management')

@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Roles Overview</h6>
                    <a href="{{ route('admin.roles.dashboard') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-chart-bar me-2"></i>Dashboard
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Admin Users Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Admin Users
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $adminUsers->count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            Full system access
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Normal Users Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Normal Users
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $normalUsers->count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            Limited access based on permissions
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users by Role -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-primary mb-3">Admin Users</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($adminUsers as $admin)
                                            <tr>
                                                <td>{{ $admin->name }}</td>
                                                <td>{{ $admin->email }}</td>
                                                <td>
                                                    @if(auth()->id() !== $admin->id)
                                                        <a href="{{ route('admin.roles.edit', $admin) }}" 
                                                           class="btn btn-sm btn-outline-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Current User</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No admin users found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-success mb-3">Normal Users</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($normalUsers as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <a href="{{ route('admin.roles.edit', $user) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No normal users found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
