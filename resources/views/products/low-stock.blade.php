@extends('layouts.app')

@section('title', 'Low Stock Products')

@section('content')
<div class="container">
    <h1>Low Stock Products</h1>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Low Stock Products Table -->
    <div class="card card-hover shadow-sm mt-4">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Low Stock Products</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->barcode }}</td>
                        <td>{{ $product->supplier?->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-danger"><i class="bi bi-exclamation-circle-fill"></i> {{ $product->quantity }}</span>
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No low stock products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $lowStockProducts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection