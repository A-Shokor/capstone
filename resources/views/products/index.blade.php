@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Products</h1>

    <!-- Create Product Button -->
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Add Product
    </a>

    <!-- Products Table -->
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Supplier</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr class="{{ $product->quantity <= 10 ? 'bg-warning' : '' }}">
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->quantity }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->supplier?->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info me-1" title="View">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection