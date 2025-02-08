@extends('layouts.app')
@section('title', 'Create Purchase Order')
@section('content')
<div class="container">
    <h1>Create Purchase Order</h1>
    <form action="{{ route('purchase-orders.store') }}" method="POST">
        @csrf

        <!-- Supplier Dropdown -->
        <div class="mb-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select class="form-select" id="supplier_id" name="supplier_id" required>
                <option value="">Select a supplier</option>
                @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Create Purchase Order
        </button>
    </form>
</div>
@endsection