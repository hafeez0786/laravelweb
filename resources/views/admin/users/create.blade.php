@extends('admin.layout')

@section('admin_content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create New User</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role_user" 
                                       value="user" {{ old('role') == 'user' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_user">
                                    Regular User
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role_admin" 
                                       value="admin" {{ old('role') == 'admin' ? 'checked' : '' }}>
                                <label class="form-check-label" for="role_admin">
                                    Administrator
                                </label>
                            </div>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
