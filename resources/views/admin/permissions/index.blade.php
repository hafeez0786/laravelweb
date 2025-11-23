@extends('admin.layout')

@section('admin_content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-shield-alt me-2"></i>Permissions Management
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <span class="badge bg-secondary text-white">
                <i class="fas fa-info-circle me-1"></i> Only updating existing permissions is allowed
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter"></i> Filter Permissions
        </div>
        <div class="card-body">
            <form action="{{ route('admin.permissions.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Search by name or description...">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @foreach($permissions->groupBy('category') as $category => $categoryPermissions)
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-folder me-2"></i>{{ $category ?: 'Uncategorized' }}
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categoryPermissions as $permission)
                                <tr>
                                    <td>
                                        <strong>{{ $permission->name }}</strong>
                                    </td>
                                    <td>
                                        <code>{{ $permission->slug }}</code>
                                    </td>
                                    <td>{{ $permission->description ?? 'No description' }}</td>
                                    <td>{{ $permission->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.permissions.edit', $permission) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Permission">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    disabled
                                                    data-bs-toggle="tooltip" 
                                                    title="Deleting permissions is not allowed">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox display-4 mb-2"></i>
                                            <div>No permissions found in this category.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    <div class="d-flex justify-content-center">
        {{ $permissions->appends(request()->query())->links() }}
    </div>

    @push('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    @endpush
@endsection
