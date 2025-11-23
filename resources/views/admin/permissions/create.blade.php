@extends('admin.layout')

@section('admin_content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create New Permission</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Permissions
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.permissions.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Permission Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Create Permission
                </button>
            </form>
        </div>
    </div>
@endsection
