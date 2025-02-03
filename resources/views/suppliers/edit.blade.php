@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Supplier</h1>
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $supplier->email) }}">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}">
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Update Supplier
        </button>
    </form>
</div>
@endsection