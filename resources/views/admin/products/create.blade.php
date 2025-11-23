@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.partials.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New Product</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @include('admin.products.form')
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
