@extends('layouts.app')

@section('title', 'Purchase Order Details')

@section('content')
<div class="container">
    <h1 class="mb-4">Purchase Order #{{ $purchaseOrder->id }}</h1>

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

    <!-- Purchase Order Details -->
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier?->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($purchaseOrder->status) }}</p>
            <p><strong>Total Cost:</strong> ${{ number_format($purchaseOrder->total_cost, 2) }}</p>
            <p><strong>Total Received Quantities:</strong> {{ $purchaseOrder->total_received_quantities }}</p>

            <!-- Display all images -->
            @if ($purchaseOrder->images->isNotEmpty())
                <div class="mt-3">
                    <h5>Uploaded Images</h5>
                    <div class="row">
                        @foreach ($purchaseOrder->images as $image)
                            <div class="col-md-4 mb-3">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Purchase Order Image" class="img-fluid" style="max-width: 100%; height: auto;">
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p>No images uploaded.</p>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back to Purchase Orders
    </a>

    <!-- Save Changes Form -->
    <form id="save-changes-form" action="{{ route('purchase-orders.save-changes', $purchaseOrder) }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="POST">

        <div class="table-responsive mt-5">
            <table class="table table-hover table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Barcode</th>
                        <th>Description</th>
                        <th>Cost</th>
                        <th>Quantity Ordered</th>
                        <th>Total Cost</th>
                        <th>Quantity Received</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchaseOrder->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->barcode }}</td>
                        <td>{{ $item->product->description }}</td>
                        <td>${{ number_format($item->product->cost, 2) }}</td>
                        <td>{{ $item->ordered_quantity }}</td>
                        <td>${{ number_format($item->product->cost * $item->ordered_quantity, 2) }}</td>
                        <td>
                            <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item->id }}">
                            <input type="number" class="form-control" name="items[{{ $loop->index }}][received_quantity]" 
                                   value="{{ $item->received_quantity }}" min="0" max="{{ $item->ordered_quantity }}" required>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No items added to this purchase order.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Save Changes
        </button>
    </form>

    <!-- Confirm Button -->
    @if ($purchaseOrder->status === 'pending')
    <form action="{{ route('purchase-orders.receive', $purchaseOrder) }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Confirm Purchase Order
        </button>
    </form>
    @endif

    <!-- Add Product Form -->
<h3 class="mt-5">Add Product</h3>
<form action="{{ route('purchase-orders.add-product', $purchaseOrder) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                    <option value="">Select a product</option>
                    @if ($products->isEmpty())
                        <option value="" disabled>No products available for this supplier</option>
                    @else
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} ({{ $product->barcode }})
                        </option>
                        @endforeach
                    @endif
                </select>
                @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity Ordered</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" 
                       value="{{ old('quantity') }}" min="1" required>
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Product
    </button>
</form>
</div>
@endsection