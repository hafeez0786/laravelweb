@extends('admin.layout')

@section('page_title', 'Edit User Role')

@section('admin_content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Role for {{ $user->name }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.roles.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="user-info" class="form-label">User Information</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1"><strong>Name:</strong> {{ $user->name }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                                    <p class="mb-0"><strong>Current Role:</strong> 
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'success' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label">Select New Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">Choose role...</option>
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                                    Normal User
                                </option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                    Administrator
                                </option>
                            </select>
                        </div>

                        @if($user->role === 'admin')
                            <div class="alert alert-warning" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Warning:</strong> Changing this user from admin to normal user will remove all administrative privileges.
                            </div>
                        @endif

                        @if(auth()->id() === $user->id)
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-ban me-2"></i>
                                <strong>Notice:</strong> You cannot change your own role.
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            @if(auth()->id() !== $user->id)
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Role
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Role Information -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Role Information</h6>
                </div>
                <div class="card-body">
                    <div class="accordion" id="roleInfoAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="adminRoleHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#adminRoleCollapse" aria-expanded="false" 
                                        aria-controls="adminRoleCollapse">
                                    <i class="fas fa-user-shield me-2 text-danger"></i>
                                    Administrator Role
                                </button>
                            </h2>
                            <div id="adminRoleCollapse" class="accordion-collapse collapse" 
                                 aria-labelledby="adminRoleHeading" data-bs-parent="#roleInfoAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled mb-0">
                                        <li><i class="fas fa-check text-success me-2"></i>Full system access</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Manage all users</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Manage roles and permissions</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Access all system features</li>
                                        <li><i class="fas fa-check text-success me-2"></i>View and edit all data</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="userRoleHeading">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#userRoleCollapse" aria-expanded="false" 
                                        aria-controls="userRoleCollapse">
                                    <i class="fas fa-user me-2 text-success"></i>
                                    Normal User Role
                                </button>
                            </h2>
                            <div id="userRoleCollapse" class="accordion-collapse collapse" 
                                 aria-labelledby="userRoleHeading" data-bs-parent="#roleInfoAccordion">
                                <div class="accordion-body">
                                    <ul class="list-unstyled mb-0">
                                        <li><i class="fas fa-check text-success me-2"></i>Limited system access</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Access based on permissions</li>
                                        <li><i class="fas fa-check text-success me-2"></i>View own profile</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Access assigned features</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>Cannot manage other users</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
