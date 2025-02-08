<!-- resources/views/components/search-bar.blade.php -->
<form action="{{ $action }}" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="query" class="form-control" placeholder="{{ $placeholder }}" value="{{ request('query') }}">
        <button type="submit" class="btn btn-secondary">
            <i class="bi bi-search"></i> Search
        </button>
    </div>
</form>