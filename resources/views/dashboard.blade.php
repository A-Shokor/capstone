@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <!-- Low Stock Alert Card -->
    <div class="card card-hover shadow-sm mb-4">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Low Stock Alerts</h5>
        </div>
        <div class="card-body">
            <p>Some products are running low on stock. Click below to view them.</p>
            <a href="{{ route('product.low-stock') }}" class="btn btn-primary w-100">
                <i class="bi bi-box-seam"></i> View Low Stock Products
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <!-- Total Products Card -->
        <div class="col-md-3">
            <div class="card card-hover shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Total Products</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h3 class="text-center">{{ $totalProducts ?? '0' }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Suppliers Card -->
        <div class="col-md-3">
            <div class="card card-hover shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> Total Suppliers</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h3 class="text-center">{{ $totalSuppliers ?? '0' }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Low Stock Products Card -->
        <div class="col-md-3">
            <div class="card card-hover shadow-sm h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-exclamation-circle-fill"></i> Low Stock Products</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h3 class="text-center">{{ $lowStockCount ?? '0' }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Stock Quantity Card -->
        <div class="col-md-3">
            <div class="card card-hover shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-boxes"></i> Total Stock Quantity</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h3 class="text-center">{{ $totalStockQuantity ?? '0' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Lab Section -->
    <div class="card card-hover shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="bi bi-boxes"></i> Stock Lab</h5>
        </div>
        <div class="card-body">
            <p>Manage stock quantities for all products. Increment or decrement stock with reasons.</p>
            <div class="d-grid gap-2">
                <a href="{{ route('stock-lab.index') }}" class="btn btn-primary">
                    <i class="bi bi-boxes"></i> Go to Stock Lab
                </a>
            </div>
        </div>
    </div>

    <!-- Purchase Orders Button -->
    <div class="card card-hover shadow-sm mt-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-cart-check-fill"></i> Purchase Orders</h5>
        </div>
        <div class="card-body">
            <p>Manage and track purchase orders from suppliers.</p>
            <div class="d-grid gap-2 d-md-block">
                <a href="{{ route('purchase-orders.index') }}" class="btn btn-light me-2">
                    <i class="bi bi-list-ul"></i> View Purchase Orders
                </a>
                <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Create New Purchase Order
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Products Table -->
    <div class="card card-hover shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recently Added Products</h5>
        </div>
        <div class="card-body">
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
@endsection