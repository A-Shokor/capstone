@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <!-- Quick Stats -->
    <div class="row">
        <div class="col-md-4">
            <div class="card card-hover shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-box-seam"></i> Total Products</h5>
                    <p class="card-text display-4">{{ $totalProducts ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-hover shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-truck"></i> Total Suppliers</h5>
                    <p class="card-text display-4">{{ $totalSuppliers ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-hover shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="bi bi-bar-chart"></i> Low Stock Alerts</h5>
                    <p class="card-text display-4">{{ $lowStockProducts ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card card-hover shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-cart"></i> Manage Products</h5>
                    <p class="card-text">Add, edit, or delete products in your inventory.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="bi bi-box-arrow-up-right"></i> Go to Products
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hover shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-truck"></i> Manage Suppliers</h5>
                    <p class="card-text">View and manage supplier details.</p>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-info">
                        <i class="bi bi-box-arrow-up-right"></i> Go to Suppliers
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection