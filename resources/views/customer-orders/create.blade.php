@extends('layouts.app')

@section('title', 'Create Customer Order')

@section('content')
<div class="container">
    <h1>Create Customer Order</h1>
    <form action="{{ route('customer-orders.store') }}" method="POST">
        @csrf

        <!-- Customer Selection -->
        <div class="mb-3">
            <label for="customer_id" class="form-label">Select Customer</label>
            <select name="customer_id" id="customer_id" class="form-select" required>
                <option value="">-- Select a Customer --</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                @endforeach
            </select>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="preparing">Preparing</option>
                <option value="ready">Ready</option>
                <option value="scheduled">Scheduled</option>
                <option value="cancel">Cancel</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>

        <!-- Products -->
        <div class="mb-3">
            <label class="form-label">Products</label>
            <div id="product-fields">
                <div class="input-group mb-2">
                    <select name="products[]" class="form-select">
                        <option value="">-- Select a Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="quantities[]" class="form-control" placeholder="Quantity" min="1" required>
                </div>
            </div>
            <button type="button" id="add-product" class="btn btn-secondary">Add Another Product</button>
        </div>

        <button type="submit" class="btn btn-primary">Create Order</button>
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