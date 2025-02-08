@extends('layouts.app')

@section('title', 'Stock Lab')

@section('content')
<div class="container">
    <h1>Stock Lab</h1>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search Bar -->
    <form action="{{ route('stock-lab.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Search by product name, barcode, or supplier..." value="{{ $query ?? '' }}">
            <button type="submit" class="btn btn-secondary">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
    </form>

    <!-- Products Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Barcode</th>
                    <th>Supplier ID</th>
                    <th>Supplier Name</th>
                    <th>Current Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->barcode }}</td>
                    <td>{{ $product->supplier?->id ?? 'N/A' }}</td>
                    <td>{{ $product->supplier?->name ?? 'N/A' }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <!-- Combined Form for Increment/Decrement -->
                        <form action="{{ route('stock-lab.update-quantity') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <!-- Action Dropdown -->
                            <select name="action" class="form-select form-select-sm me-2" style="width: auto;" required>
                                <option value="increment">Increment</option>
                                <option value="decrement">Decrement</option>
                            </select>

                            <!-- Quantity Input -->
                            <input type="number" name="quantity" min="1" value="1" class="form-control form-control-sm me-2" style="width: 80px;" required>

                            <!-- Reason Dropdown (only visible for decrement) -->
                            <select name="reason" id="reason-{{ $product->id }}" class="form-select form-select-sm d-none" style="width: auto;">
                                <option value="" disabled selected>Select Reason</option>
                                <option value="lost">Lost</option>
                                <option value="stolen/damaged">Stolen/Damaged</option>
                                <option value="expired">Expired</option>
                            </select>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-check-circle"></i> Apply
                            </button>
                        </form>

                        <!-- JavaScript to Toggle Reason Field -->
                        <script>
                            document.querySelector('select[name="action"]').addEventListener('change', function () {
                                const reasonField = document.getElementById('reason-{{ $product->id }}');
                                if (this.value === 'decrement') {
                                    reasonField.classList.remove('d-none');
                                    reasonField.setAttribute('required', true);
                                } else {
                                    reasonField.classList.add('d-none');
                                    reasonField.removeAttribute('required');
                                }
                            });
                        </script>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection