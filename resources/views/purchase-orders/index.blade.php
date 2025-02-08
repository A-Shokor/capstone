@extends('layouts.app')

@section('title', 'Purchase Orders')

@section('content')
<div class="container">
    <h1>Purchase Orders</h1>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Create Purchase Order Button -->
    <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Create New Purchase Order
    </a>

    <!-- Live Search Bar -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Search purchase orders by supplier or status...">
    </div>

    <!-- Purchase Orders Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th>Total Items</th>
                    <th>Total Quantity Ordered</th>
                    <th>Total Received Quantities</th>
                    <th>Total Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="purchase-orders-table-body">
                @forelse ($purchaseOrders as $purchaseOrder)
                <tr>
                    <td>{{ $purchaseOrder->id }}</td>
                    <td>{{ $purchaseOrder->supplier?->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($purchaseOrder->status) }}</td>
                    <td>{{ $purchaseOrder->items->count() }}</td>
                    <td>{{ $purchaseOrder->items->sum('ordered_quantity') }}</td>
                    <td>{{ $purchaseOrder->total_received_quantities }}</td>
                    <td>${{ number_format($purchaseOrder->total_cost, 2) }}</td>
                    <td>
                        <a href="{{ route('purchase-orders.show', $purchaseOrder) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <form action="{{ route('purchase-orders.destroy', $purchaseOrder) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this purchase order?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No purchase orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript for Live Search -->
<script>
document.getElementById('search').addEventListener('input', function () {
    const query = this.value.trim();
    if (query.length > 0) {
        fetch(`/purchase-orders/search?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('purchase-orders-table-body');
                tableBody.innerHTML = ''; // Clear the table body
                if (data.length > 0) {
                    data.forEach(purchaseOrder => {
                        const row = `
                            <tr>
                                <td>${purchaseOrder.id}</td>
                                <td>${purchaseOrder.supplier?.name || 'N/A'}</td>
                                <td>${purchaseOrder.status}</td>
                                <td>${purchaseOrder.items_count}</td>
                                <td>${purchaseOrder.total_ordered_quantity}</td>
                                <td>${purchaseOrder.total_received_quantities}</td>
                                <td>$${parseFloat(purchaseOrder.total_cost).toFixed(2)}</td>
                                <td>
                                    <a href="/purchase-orders/${purchaseOrder.id}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <form action="/purchase-orders/${purchaseOrder.id}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this purchase order?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="8" class="text-center">No purchase orders found.</td></tr>';
                }
            })
            .catch(error => console.error('Error fetching purchase orders:', error));
    } else {
        location.reload(); // Reload the page if the search bar is cleared
    }
});
</script>
@endsection