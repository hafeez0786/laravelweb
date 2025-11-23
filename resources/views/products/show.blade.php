@extends('user.layout')

@section('page_title', 'Product Details')

@section('user_content')
    <div class="card">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-box me-2"></i>Product Details
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Products
                    </a>
                    @if(auth()->user()->hasPermission('edit_products'))
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit Product
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Sample Product Data -->
            <?php
            $sampleProduct = [
                'id' => 1,
                'name' => 'Laptop Pro',
                'category' => 'Electronics',
                'price' => 1299.99,
                'status' => 'In Stock',
                'description' => 'High-performance laptop with latest processor and graphics card.',
                'features' => ['Intel Core i7', '16GB RAM', '512GB SSD', '15.6" Display'],
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=300&fit=crop&crop=center&auto=format'
            ];
            
            // Use sample data if no product is provided
            if (!isset($product)) {
                $product = $sampleProduct;
            }
            
            // Ensure image key exists
            if (!isset($product['image'])) {
                $product['image'] = $sampleProduct['image'];
            }
            ?>
            
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ $product['image'] }}" class="img-fluid rounded" alt="{{ $product['name'] }}">
                </div>
                <div class="col-md-8">
                    <h3>{{ $product['name'] }}</h3>
                    <div class="mb-3">
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-tag me-1"></i>{{ $product['category'] }}
                        </span>
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>{{ $product['status'] }}
                        </span>
                    </div>
                    <div class="h4 text-primary mb-3">${{ number_format($product['price'], 2) }}</div>
                    <p class="text-muted">{{ $product['description'] }}</p>
                    
                    <h5 class="mt-4 mb-3">Features</h5>
                    <ul class="list-unstyled">
                        @foreach($product['features'] as $feature)
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="mt-4">
                        @if(auth()->user()->hasPermission('purchase_products'))
                        <button class="btn btn-success btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Purchase Now
                        </button>
                        @endif
                        <button class="btn btn-outline-primary btn-lg ms-2">
                            <i class="fas fa-heart me-2"></i>Add to Wishlist
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
