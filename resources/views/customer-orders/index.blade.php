@extends('layouts.app')

@section('title', 'Active Customer Orders')

@section('content')
<div class="container">
    <h1>Active Customer Orders</h1>
    <p>These are the orders that are currently active.</p>

    <!-- Button to Order History -->
    <div class="mb-4">
        <a href="{{ route('customer-orders.history') }}" class="btn btn-primary">
            <i class="bi bi-clock-history me-2"></i> View Order History
        </a>
    </div>

    <!-- Active Orders Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customerOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer?->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>${{ number_format($order->items->sum(function ($item) {
                        return $item->product->price * $item->quantity;
                    }), 2) }}</td>
                    <td>
                        <!-- View Button -->
                        <a href="{{ route('customer-orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>

                        <!-- Cancel Button -->
                        <form action="{{ route('customer-orders.cancel', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this order?')">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No active orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Back Button -->
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection