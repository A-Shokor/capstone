@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <h1 class="mb-4 fw-bold text-gradient">Dashboard</h1>

    <!-- Low Stock Alert Card -->
    <div class="card card-hover shadow-lg mb-4 animate__animated animate__fadeIn">
        <div class="card-header bg-warning text-white d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-2"></i>
            <h5 class="mb-0">Low Stock Alerts</h5>
        </div>
        <div class="card-body">
            <p class="mb-3">Some products are running low on stock. Click below to view them.</p>
            <a href="{{ route('product.low-stock') }}" class="btn btn-primary w-100 btn-hover-scale">
                <i class="bi bi-box-seam me-2"></i> View Low Stock Products
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Products Card -->
        <div class="col-md-3">
            <div class="card card-hover shadow-sm h-100 animate__animated animate__fadeInUp">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-box-seam fs-4 me-2"></i>
                    <h5 class="mb-0">Total Products</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h3 class="text-center display-4 fw-bold text-gradient">{{ $totalProducts ?? '0' }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Suppliers Card -->
        <div class="col-md-3">
            <div class="card card-hover shadow-sm h-100 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="card-header bg-info text-white d-flex align-items-center">
                    <i class="bi bi-truck fs-4 me-2"></i>
                    <h5 class="mb-0">Total Suppliers</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h3 class="text-center display-4 fw-bold text-gradient">{{ $totalSuppliers ?? '0' }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Low Stock Products Card -->
        <div class="col-md-3">
            <div class="card card-hover shadow-sm h-100 animate__animated animate__fadeInUp animate__delay-2s">
                <div class="card-header bg-danger text-white d-flex align-items-center">
                    <i class="bi bi-exclamation-circle-fill fs-4 me-2"></i>
                    <h5 class="mb-0">Low Stock Products</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h3 class="text-center display-4 fw-bold text-gradient">{{ $lowStockCount ?? '0' }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Stock Quantity Card -->
        <div class="col-md-3">
            <div class="card card-hover shadow-sm h-100 animate__animated animate__fadeInUp animate__delay-3s">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-boxes fs-4 me-2"></i>
                    <h5 class="mb-0">Total Stock Quantity</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h3 class="text-center display-4 fw-bold text-gradient">{{ $totalStockQuantity ?? '0' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Lab Section -->
    <div class="card card-hover shadow-lg mt-4 animate__animated animate__fadeIn">
        <div class="card-header bg-secondary text-white d-flex align-items-center">
            <i class="bi bi-boxes fs-4 me-2"></i>
            <h5 class="mb-0">Stock Lab</h5>
        </div>
        <div class="card-body">
            <p class="mb-3">Manage stock quantities for all products. Increment or decrement stock with reasons.</p>
            <div class="d-grid">
                <a href="{{ route('stock-lab.index') }}" class="btn btn-primary btn-hover-scale">
                    <i class="bi bi-boxes me-2"></i> Go to Stock Lab
                </a>
            </div>
        </div>
    </div>

    <!-- Purchase Orders Section -->
    <div class="card card-hover shadow-lg mt-4 animate__animated animate__fadeIn">
        <div class="card-header bg-success text-white d-flex align-items-center">
            <i class="bi bi-cart-check-fill fs-4 me-2"></i>
            <h5 class="mb-0">Purchase Orders</h5>
        </div>
        <div class="card-body">
            <p class="mb-3">Manage and track purchase orders from suppliers.</p>
            <div class="d-grid gap-2 d-md-flex">
                <a href="{{ route('purchase-orders.index') }}" class="btn btn-light btn-hover-scale me-2">
                    <i class="bi bi-list-ul me-2"></i> View Purchase Orders
                </a>
                <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary btn-hover-scale">
                    <i class="bi bi-plus-circle me-2"></i> Create New Purchase Order
                </a>
            </div>
        </div>
    </div>

    <!-- Customer Orders Section -->
    <div class="card card-hover shadow-lg mt-4 animate__animated animate__fadeIn">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-cart4 fs-4 me-2"></i>
            <h5 class="mb-0">Customer Orders</h5>
        </div>
        <div class="card-body">
            <p class="mb-3">Manage and track customer orders.</p>
            <div class="d-grid gap-2 d-md-flex">
                <a href="{{ route('customer-orders.index') }}" class="btn btn-light btn-hover-scale me-2">
                    <i class="bi bi-list-ul me-2"></i> View Customer Orders
                </a>
                <a href="{{ route('customer-orders.create') }}" class="btn btn-primary btn-hover-scale">
                    <i class="bi bi-plus-circle me-2"></i> Create New Customer Order
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Products Table -->
    <div class="card card-hover shadow-lg mt-4 animate__animated animate__fadeIn">
        <div class="card-header bg-secondary text-white d-flex align-items-center">
            <i class="bi bi-clock-history fs-4 me-2"></i>
            <h5 class="mb-0">Recently Added Products</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Supplier</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Added On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentProducts as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->supplier?->name ?? 'N/A' }}</td>
                            <td>
                                @if ($product->quantity <= 10)
                                    <span class="badge bg-danger"><i class="bi bi-exclamation-circle-fill"></i> {{ $product->quantity }}</span>
                                @else
                                    {{ $product->quantity }}
                                @endif
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Animations and Hover Effects -->
<style>
    .card-hover:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
    .btn-hover-scale:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    .text-gradient {
        background: linear-gradient(45deg, #007bff, #00ff88);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<!-- Animate.css for Animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endsection