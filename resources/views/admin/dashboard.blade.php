@extends('admin.layout')

@section('page_title', 'Admin Dashboard')

@section('admin_content')
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\User::count() }}</div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\User::where('role', 'user')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
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
                                Admin Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\User::where('role', 'admin')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Permissions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ App\Models\Permission::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shield-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
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
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-circle btn-lg mb-2">
                                <i class="fas fa-users"></i>
                            </a>
                            <br>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">Manage Users</a>
                        </div>
                        <div class="col-md-3 text-center mb-3">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-success btn-circle btn-lg mb-2">
                                <i class="fas fa-user-cog"></i>
                            </a>
                            <br>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-success">Manage Roles</a>
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
