@extends('admin.layout')

@section('admin_content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-users me-2"></i>Users Management
            <span class="badge bg-secondary">{{ $users->total() }}</span>
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Add New User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-group input-group-sm" style="max-width: 300px;">
                            <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Search users...">
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-secondary" id="exportBtn">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="80">ID <i class="fas fa-sort text-muted"></i></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-end" width="220">Actions</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center">
                                            <span class="text-uppercase fw-bold text-muted">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">Joined {{ $user->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'primary' : 'secondary' }}">
                                    <i class="fas fa-{{ $user->role === 'admin' ? 'shield-alt' : 'user' }} me-1"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }} bg-opacity-10 text-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                    <i class="fas fa-{{ $user->email_verified_at ? 'check-circle' : 'clock' }} me-1"></i>
                                    {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="btn btn-sm btn-outline-secondary action-btns"
                                       data-bs-toggle="tooltip"
                                       title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="btn btn-sm btn-outline-primary action-btns"
                                       data-bs-toggle="tooltip"
                                       title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                          method="POST" 
                                          class="d-inline delete-form"
                                          onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger action-btns"
                                                data-bs-toggle="tooltip"
                                                title="Delete User"
                                                {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($users->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="mb-2 mb-md-0 text-muted small">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous Page Link --}}
                                @if ($users->onFirstPage())
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link">&laquo; Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                                    </li>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    @if ($page == $users->currentPage())
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($users->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next &raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled" aria-disabled="true">
                                        <span class="page-link">Next &raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function(e) {
                    const searchValue = this.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchValue) ? '' : 'none';
                    });
                });
            }

            // Confirm before deleting
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    <style>
        /* Table Styles */
        .table th {
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-top: none;
            padding: 0.75rem 1rem;
            white-space: nowrap;
        }
        .table td {
            vertical-align: middle;
            padding: 1rem;
            border-color: #f1f3f7;
        }
        .table-hover > tbody > tr:hover {
            background-color: rgba(13, 110, 253, 0.03);
        }
        
        /* Badge Styles */
        .badge {
            font-weight: 500;
            padding: 0.4em 0.8em;
            font-size: 0.75em;
            letter-spacing: 0.3px;
        }
        
        /* Button Styles */
        .btn-sm {
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            border-radius: 0.25rem;
        }
        
        .action-btns .btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .action-btns .btn:hover {
            transform: translateY(-1px);
        }
        
        /* Pagination Styles */
        .pagination {
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }
        
        .pagination .page-item {
            margin: 0;
        }
        
        .pagination .page-link {
            border: 1px solid #dee2e6;
            color: #6c757d;
            min-width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.25rem 0.5rem;
            font-size: 0.8125rem;
            font-weight: 400;
            transition: all 0.15s ease;
            background-color: #fff;
            border-radius: 0.25rem;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }
        
        .pagination .page-item:not(.active):not(.disabled) .page-link:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #0d6efd;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            opacity: 0.7;
        }
        
        /* Card Footer */
        .card-footer {
            padding: 0.75rem 1.25rem;
            background-color: rgba(0, 0, 0, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .pagination {
                gap: 0.15rem;
            }
            
            .pagination .page-link {
                min-width: 28px;
                height: 28px;
                font-size: 0.75rem;
                padding: 0.25rem;
            }
            
            .table th, .table td {
                padding: 0.75rem 0.5rem;
            }
            
            .pagination .page-link:not([rel="prev"]):not([rel="next"]) {
                min-width: 28px;
                padding: 0.25rem;
            }
        }
    </style>
    @endpush
@endsection
