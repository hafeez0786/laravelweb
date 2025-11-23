@extends('user.layout')

@section('page_title', 'Products')

@section('user_content')
    <div class="card">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-box me-2"></i>Products
                </h4>
                <div class="d-flex gap-2">
                    @if(auth()->user()->hasPermission('create_products'))
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add Product
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Sample Products Data -->
            <?php
            $sampleProducts = [
                ['id' => 1, 'name' => 'Laptop Pro', 'category' => 'Electronics', 'price' => 1299.99, 'status' => 'In Stock'],
                ['id' => 2, 'name' => 'Wireless Mouse', 'category' => 'Electronics', 'price' => 29.99, 'status' => 'In Stock'],
                ['id' => 3, 'name' => 'USB-C Hub', 'category' => 'Accessories', 'price' => 49.99, 'status' => 'Limited Stock'],
                ['id' => 4, 'name' => 'Mechanical Keyboard', 'category' => 'Electronics', 'price' => 149.99, 'status' => 'In Stock'],
                ['id' => 5, 'name' => 'Monitor Stand', 'category' => 'Accessories', 'price' => 39.99, 'status' => 'Out of Stock'],
            ];
            $products = $products ?? $sampleProducts;
            ?>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="fas fa-box text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $product['name'] }}</h6>
                                        <small class="text-muted">SKU: PRD-00{{ $product['id'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-tag me-1"></i>{{ $product['category'] }}
                                </span>
                            </td>
                            <td>
                                <span class="h5 text-primary mb-0">${{ number_format($product['price'], 2) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product['status'] === 'In Stock' ? 'success' : ($product['status'] === 'Limited Stock' ? 'warning' : 'danger') }}">
                                    <i class="fas fa-{{ $product['status'] === 'In Stock' ? 'check-circle' : ($product['status'] === 'Limited Stock' ? 'exclamation-triangle' : 'times-circle') }} me-1"></i>
                                    {{ $product['status'] }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('products.show', $product['id']) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->hasPermission('edit_products'))
                                    <a href="#" class="btn btn-sm btn-outline-secondary" title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('purchase_products'))
                                    <a href="#" class="btn btn-sm btn-success" title="Purchase">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                    @endif
                                    @if(auth()->user()->hasPermission('delete_products'))
                                    <button class="btn btn-sm btn-outline-danger" title="Delete Product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(!isset($products) || count($products) == 0)
            <div class="text-center py-4">
                <i class="fas fa-inbox display-4 text-muted mb-3"></i>
                <p class="text-muted mb-0">No products available at the moment</p>
                <p class="small text-muted">Please check back later or contact support for more information.</p>
            </div>
            @endif
        </div>
    </div>
@endsection
