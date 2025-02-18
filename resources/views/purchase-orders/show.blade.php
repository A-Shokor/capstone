@extends('layouts.app')

@section('title', 'Purchase Order Details')

@section('content')
<div class="container">
    <h1>Purchase Order #{{ $purchaseOrder->id }}</h1>

    <!-- Purchase Order Details -->
    <div class="card card-hover shadow-sm mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="bi bi-cart-check-fill"></i> Purchase Order Details</h5>
        </div>
        <div class="card-body">
            <!-- Debugging Statement -->
            <p>Image Path: {{ $purchaseOrder->image ?? 'No image uploaded' }}</p>
            <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier?->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($purchaseOrder->status) }}</p>
            <p><strong>Total Items:</strong> {{ $purchaseOrder->items->count() }}</p>
            <p><strong>Total Quantity Ordered:</strong> {{ $purchaseOrder->items->sum('ordered_quantity') }}</p>
            <p><strong>Total Received Quantities:</strong> {{ $purchaseOrder->items->sum('received_quantity') }}</p>
            <p><strong>Total Cost:</strong> ${{ number_format($purchaseOrder->items->sum(function ($item) {
                return $item->ordered_quantity * $item->unit_cost;
            }), 2) }}</p>
        </div>
    </div>

    <!-- Upload Image Section -->
   <!-- Upload Image Section -->
<div class="card card-hover shadow-sm mb-4">
    <div class="card-header bg-dark text-white d-flex align-items-center">
        <i class="bi bi-upload fs-4 me-2"></i>
        <h5 class="mb-0">Upload Image</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('purchase-orders.upload-image', $purchaseOrder) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label">Select an image file</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-upload me-2"></i> Upload Image
            </button>
        </form>
    </div>
</div>
   <!-- View Uploaded Images Section -->
@if ($purchaseOrder->images->isNotEmpty())
<div class="card card-hover shadow-sm mb-4">
    <div class="card-header bg-dark text-white d-flex align-items-center">
        <i class="bi bi-image fs-4 me-2"></i>
        <h5 class="mb-0">Uploaded Images</h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($purchaseOrder->images as $image)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('storage/' . $image->image) }}" alt="Purchase Order Image" class="card-img-top img-fluid">
                    <div class="card-body text-center">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imageModal{{ $image->id }}">
                            <i class="bi bi-eye me-2"></i> View Image
                        </button>
                    </div>
                </div>

                <!-- Modal for Displaying the Image -->
                <div class="modal fade" id="imageModal{{ $image->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Uploaded Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="Purchase Order Image" class="img-fluid">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    No images have been uploaded for this purchase order.
</div>
@endif
    <!-- Ordered Products Table -->
    <div class="card card-hover shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bi bi-box-seam"></i> Ordered Products</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('purchase-orders.save-changes', $purchaseOrder) }}" method="POST">
                @csrf
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Product Name</th>
                            <th>Ordered Quantity</th>
                            <th>Received Quantity</th>
                            <th>Unit Cost</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchaseOrder->items as $item)
                        <tr>
                            <td>{{ $item->product?->name ?? 'N/A' }}</td>
                            <td>{{ $item->ordered_quantity }}</td>
                            <td>
                                <input type="number" name="items[{{ $loop->index }}][received_quantity]" 
                                    value="{{ $item->received_quantity }}" min="0" class="form-control" required>
                                <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item->id }}">
                            </td>
                            <td>${{ number_format($item->unit_cost, 2) }}</td>
                            <td>${{ number_format($item->ordered_quantity * $item->unit_cost, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No items found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Save Changes Button -->
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Save Changes
                </button>
            </form>
        </div>
    </div>

    <!-- Add Product Form -->
    <div class="card card-hover shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Add Product</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('purchase-orders.add-product', $purchaseOrder) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="product_id" class="form-label">Product</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">Select a product</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->barcode }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle"></i> Add Product
                </button>
            </form>
        </div>
    </div>

    <!-- Confirm Purchase Order Button -->
    @if ($purchaseOrder->status === 'pending')
    <div class="d-grid gap-2">
        <form action="{{ route('purchase-orders.receive', $purchaseOrder) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Confirm Purchase Order
            </button>
        </form>
    </div>
    @endif

    <!-- Send Order Email Button -->
    <div class="d-grid gap-2 mt-3">
        <form action="{{ route('purchase-orders.send-order-email', $purchaseOrder) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-info">
                <i class="bi bi-envelope-fill"></i> Send Order to Supplier
            </button>
        </form>
    </div>
</div>

<!-- Bootstrap JS for Modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection