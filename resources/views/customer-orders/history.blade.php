@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container">
    <h1>Order History</h1>
    <p>These are the orders that have been marked as "received" or "canceled".</p>

    <!-- Archived Orders Table -->
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
            @forelse ($archivedOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer?->name ?? 'N/A' }}</td>
                    <td>
                        @if ($order->status === 'received')
                            <span class="badge bg-success">Received</span>
                        @elseif ($order->status === 'canceled')
                            <span class="badge bg-danger">Canceled</span>
                        @endif
                    </td>
                    <td>${{ number_format($order->items->sum(function ($item) {
                        return $item->product->price * $item->quantity;
                    }), 2) }}</td>
                    <td>
                        <a href="{{ route('customer-orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No archived orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Back Button -->
    <a href="{{ route('customer-orders.index') }}" class="btn btn-secondary">Back to Active Orders</a>
</div>
@endsection