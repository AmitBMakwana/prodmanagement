@extends('layouts.app')

@section('content')
<h1>Products</h1>

@if(session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif
<a href="{{ route('products.create') }}">Create</a>
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
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>
                    <input type="checkbox" class="status-checkbox" data-product-id="{{ $product->id }}"
                        {{ $product->is_active =="1" ? 'checked' : '' }}>
                </td>
            </tr>
            {{ $products->links() }}

        @endforeach
    </tbody>
</table>

<div>
</div>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
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
