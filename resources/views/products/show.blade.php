@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="container">
    <h1>Product Details</h1>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Back Button -->
    <a href="{{ route('product.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>

    <!-- Product Details -->
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $product->name }}</p>
            <p><strong>Barcode:</strong> {{ $product->barcode }}</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Cost:</strong> ${{ number_format($product->cost, 2) }}</p>
            <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
            <p><strong>Description:</strong> {{ $product->description ?? 'N/A' }}</p>
            <p><strong>Supplier:</strong> {{ $product->supplier?->name ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Edit Button -->
    <a href="{{ route('product.edit', $product) }}" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Edit Product
    </a>
</div>
@endsection