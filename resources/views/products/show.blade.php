@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Quantity:</strong> {{ $product->quantity }}</p>
            <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p><strong>Description:</strong> {{ $product->description ?? 'N/A' }}</p>
            <p><strong>Barcode:</strong> {{ $product->barcode ?? 'N/A' }}</p>
            <p><strong>Supplier:</strong> {{ $product->supplier?->name ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Back Button -->
    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>
@endsection