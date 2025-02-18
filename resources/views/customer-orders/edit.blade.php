@extends('layouts.app')

@section('title', 'Edit Customer Order')

@section('content')
<div class="container">
    <h1>Edit Customer Order</h1>
    <form action="{{ route('customer-orders.update', $customerOrder) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Customer Selection -->
        <div class="mb-3">
            <label for="customer_id" class="form-label">Select Customer</label>
            <select name="customer_id" id="customer_id" class="form-select" required>
                <option value="">-- Select a Customer --</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $customerOrder->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }} ({{ $customer->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="preparing" {{ $customerOrder->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                <option value="ready" {{ $customerOrder->status == 'ready' ? 'selected' : '' }}>Ready</option>
                <option value="scheduled" {{ $customerOrder->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="cancel" {{ $customerOrder->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                <option value="delivered" {{ $customerOrder->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
            </select>
        </div>

        <!-- Products -->
        <div class="mb-3">
            <label class="form-label">Products</label>
            <div id="product-fields">
                @foreach ($customerOrder->items as $item)
                    <div class="input-group mb-2">
                        <select name="products[]" class="form-select">
                            <option value="">-- Select a Product --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="quantities[]" class="form-control" placeholder="Quantity" min="1" value="{{ $item->quantity }}" required>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-product" class="btn btn-secondary">Add Another Product</button>
        </div>

        <button type="submit" class="btn btn-primary">Update Order</button>
    </form>
</div>

<script>
    // Dynamically Add More Product Fields
    document.getElementById('add-product').addEventListener('click', function () {
        const productFields = document.getElementById('product-fields');
        const newField = `
            <div class="input-group mb-2">
                <select name="products[]" class="form-select">
                    <option value="">-- Select a Product --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <input type="number" name="quantities[]" class="form-control" placeholder="Quantity" min="1" required>
            </div>
        `;
        productFields.insertAdjacentHTML('beforeend', newField);
    });
</script>
@endsection