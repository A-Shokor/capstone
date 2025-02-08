@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Supplier Details Card -->
            <div class="card card-hover shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> Supplier Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row"><i class="bi bi-person-circle"></i> Name</th>
                                <td>{{ $supplier->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><i class="bi bi-envelope"></i> Email</th>
                                <td>{{ $supplier->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th scope="row"><i class="bi bi-telephone"></i> Phone</th>
                                <td>{{ $supplier->phone ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Low Stock Alert -->
            @if ($lowStockProducts->isNotEmpty())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> 
                    The following products are running low on stock:
                    <ul>
                        @foreach ($lowStockProducts as $product)
                            <li>{{ $product->name }} (Quantity: {{ $product->quantity }})</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Associated Products Table -->
            <div class="card card-hover shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Associated Products</h5>
                </div>
                <div class="card-body">
                    @if ($supplier->products->isEmpty())
                        <p class="text-muted">No products associated with this supplier.</p>
                    @else
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supplier->products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        @if ($product->quantity <= 10)
                                            <span class="badge bg-danger"><i class="bi bi-exclamation-circle-fill"></i> {{ $product->quantity }}</span>
                                        @else
                                            {{ $product->quantity }}
                                        @endif
                                    </td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->description ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-3">
                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Suppliers
                </a>
            </div>
        </div>
    </div>
</div>
@endsection