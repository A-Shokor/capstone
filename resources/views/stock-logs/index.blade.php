@extends('layouts.app')

@section('title', 'Stock Logs')

@section('content')
<div class="container">
    <h1>Stock Logs</h1>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Logs Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Action</th>
                    <th>Quantity</th>
                    <th>Reason</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->product?->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($log->action) }}</td>
                    <td>{{ $log->quantity }}</td>
                    <td>{{ $log->reason ?? 'N/A' }}</td>
                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No logs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $logs->links() }}
    </div>
</div>
@endsection