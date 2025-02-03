@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Suppliers</h1>

    <!-- Create Supplier Button -->
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Add Supplier
    </a>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="searchSupplier" class="form-control" placeholder="Search suppliers...">
    </div>

    <!-- Suppliers Table -->
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->id }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->phone }}</td>
                <td>
                    <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-info me-1" title="View">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Search Script -->
<script>
document.getElementById('searchSupplier').addEventListener('input', function () {
    const query = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        const name = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
        row.style.display = name.includes(query) ? '' : 'none';
    });
});
</script>
@endsection