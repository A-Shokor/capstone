@extends('layouts.app')

@section('title', 'Customer Order Details')

@section('content')
<div class="container">
    <!-- Customer Details Card -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Customer Details</h5>
            <p><strong>Name:</strong> {{ $customerOrder->customer->name }}</p>
            <p><strong>Email:</strong> {{ $customerOrder->customer->email }}</p>
            <p><strong>Phone:</strong> {{ $customerOrder->customer->phone ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $customerOrder->customer->address ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Status Changer -->
    <div class="mb-4">
        <form action="{{ route('customer-orders.update-status', $customerOrder->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <label for="status" class="me-2">Change Status:</label>
            <select name="status" id="status" class="form-select d-inline" style="width: auto;">
                <option value="preparing" {{ $customerOrder->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                <option value="ready" {{ $customerOrder->status == 'ready' ? 'selected' : '' }}>Ready</option>
                <option value="scheduled" {{ $customerOrder->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="cancel" {{ $customerOrder->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                <option value="delivering" {{ $customerOrder->status == 'delivering' ? 'selected' : '' }}>delivering</option>
                <option value="received" {{ $customerOrder->status == 'received' ? 'selected' : '' }}>Received</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
        </form>
    </div>

    <!-- Ordered Products Table -->
    <div class="card mb-4">
        <div class="card-header">
            Ordered Products
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customerOrder->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>
                                <input type="number" class="form-control quantity-input" data-item-id="{{ $item->id }}" value="{{ $item->quantity }}" min="1" style="width: 80px;">
                            </td>
                            <td>${{ number_format($item->product->price, 2) }}</td>
                            <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger delete-item" data-item-id="{{ $item->id }}">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Product Form -->
    <div class="card mb-4">
        <div class="card-header">
            Add Product to Order
        </div>
        <div class="card-body">
            <form action="{{ route('customer-order-items.store') }}" method="POST">
                @csrf
                <input type="hidden" name="customer_order_id" value="{{ $customerOrder->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <label for="product_id" class="form-label">Select Product</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">-- Select a Product --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (${{ number_format($product->price, 2) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Total Price -->
    <div class="d-flex justify-content-end mb-4">
        <h4>Total Price: ${{ number_format($customerOrder->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        }), 2) }}</h4>
    </div>

    <!-- Back Button -->
    <a href="{{ route('customer-orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>

<!-- JavaScript for Actions -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Adjust Quantity
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function () {
            const itemId = this.dataset.itemId;
            const newQuantity = this.value;

            // Send AJAX request to update the quantity
            fetch(`/customer-order-items/${itemId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: newQuantity })
            }).then(response => {
                if (response.ok) {
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Failed to update quantity.');
                }
            });
        });
    });

    // Remove Item
    document.querySelectorAll('.delete-item').forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.dataset.itemId;

            if (confirm('Are you sure you want to remove this item?')) {
                // Send AJAX request to delete the item
                fetch(`/customer-order-items/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to remove item.');
                    }
                });
            }
        });
    });
});
</script>
@endsection