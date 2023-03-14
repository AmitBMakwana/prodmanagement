@extends('layouts.app')

@section('content')
<h1>Products</h1>

@if(session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif

<form method="GET" action="{{ route('products.index') }}">
    <div>
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" value="{{ old('search') }}">
        <button type="submit">Search</button>
    </div>
</form>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->category->name }}</td>
                <td>
                    <input type="checkbox" class="status-checkbox" data-product-id="{{ $product->id }}"
                        {{ $product->is_active ? 'checked' : '' }}>
                </td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}">View</a>
                    <a href="{{ route('products.edit', $product->id) }}">Edit</a>
                    <form method="POST"
                        action="{{ route('products.destroy', $product->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div>
    {{ $products->appends(['search' => old('search')])->links() }}
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('body').on('change', '.status-checkbox', function () {
            var status = $(this).is(':checked') ? 1 : 0;
            var productId = $(this).data('product-id');
            $.ajax({
                type: "POST",
                url: "{{ route('products.changeStatus') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "product_id": productId,
                    "status": status
                },
                success: function (response) {
                    if (response.success) {
                        alert('Product status changed successfully.');
                    }
                },
                error: function (response) {
                    alert('Error changing product status.');
                }
            });
        });
    });

</script>
