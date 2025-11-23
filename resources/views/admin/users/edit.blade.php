@extends('admin.layout')

@section('page_title', 'Edit User')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit User: {{ $user->name }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Leave blank to keep current">
                            <div class="form-text">Minimum 8 characters</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Type <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role_user" 
                                       value="user" {{ old('role', $user->role) == 'user' ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium" for="role_user">
                                    <i class="fas fa-user me-1"></i> Regular User
                                </label>
                                <div class="form-text text-muted">Limited access based on assigned permissions</div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role_admin" 
                                       value="admin" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium" for="role_admin">
                                    <i class="fas fa-user-shield me-1"></i> Administrator
                                </label>
                                <div class="form-text text-muted">Full access to all features</div>
                            </div>
                        </div>
                        @error('role')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Permissions Management -->
                    @if(!$user->isAdmin())
                        <div class="mb-4">
                            <label class="form-label">User Permissions</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    @forelse($permissions as $category => $categoryPermissions)
                                        <div class="mb-3">
                                            <h6 class="fw-bold text-uppercase small text-muted mb-2">
                                                {{ $category ?: 'General' }}
                                            </h6>
                                            <div class="row">
                                                @foreach($categoryPermissions as $permission)
                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" 
                                                                   name="permissions[]" 
                                                                   value="{{ $permission->id }}"
                                                                   id="permission_{{ $permission->id }}"
                                                                   {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                            @if($permission->description)
                                                                <small class="text-muted d-block">{{ $permission->description }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted">No permissions available</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Users
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Permission Management Panel -->
    @if(!$user->isAdmin())
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Quick Permission Actions</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.permissions.grant', $user->id) }}" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small">Grant Permissions</label>
                            <select name="permissions[]" class="form-select form-select-sm" multiple>
                                @foreach($permissions as $category => $categoryPermissions)
                                    @foreach($categoryPermissions as $permission)
                                        @if(!in_array($permission->id, $userPermissions))
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success w-100">
                            <i class="fas fa-plus me-1"></i> Grant Selected
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.users.permissions.revoke', $user->id) }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small">Revoke Permissions</label>
                            <select name="permissions[]" class="form-select form-select-sm" multiple>
                                @foreach($permissions as $category => $categoryPermissions)
                                    @foreach($categoryPermissions as $permission)
                                        @if(in_array($permission->id, $userPermissions))
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-danger w-100">
                            <i class="fas fa-minus me-1"></i> Revoke Selected
                        </button>
                    </form>
                </div>
            </div>

            <!-- Current Permissions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Current Permissions</h6>
                </div>
                <div class="card-body">
                    @if(count($userPermissions) > 0)
                        <div class="small">
                            @foreach($permissions as $category => $categoryPermissions)
                                @foreach($categoryPermissions as $permission)
                                    @if(in_array($permission->id, $userPermissions))
                                        <span class="badge bg-primary me-1 mb-1">{{ $permission->name }}</span>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small">No permissions assigned</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
