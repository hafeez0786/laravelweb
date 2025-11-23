@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">User Details: {{ $user->name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Back to Users
                    </a>
                    @can('edit-users')
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    @endcan
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">User Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>ID:</th>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role:</th>
                                    <td>
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email Verified:</th>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Verified
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-exclamation-triangle"></i> Not Verified
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Assigned Permissions</h5>
                        </div>
                        <div class="card-body">
                            @if($user->permissions->count() > 0)
                                <div class="row">
                                    @foreach($user->permissions as $permission)
                                        <div class="col-md-6 mb-2">
                                            <span class="badge bg-info text-dark">
                                                <i class="bi bi-shield-lock"></i> {{ $permission->name }}
                                            </span>
                                            <small class="text-muted d-block">{{ $permission->description }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info mb-0">
                                    No specific permissions assigned. This user only has default permissions.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
