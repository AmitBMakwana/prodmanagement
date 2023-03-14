@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Add Product</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('products.store') }}" method="post">
        @csrf

        <div>
            <label>Product Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Product Description:</label>
            <textarea name="description" id="description" value="{{ old('description') }}"></textarea>
            @error('description')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Product Price:</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" required>
            @error('price')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Product Qty:</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" required>
            @error('quantity')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Select Category</label>
            <select name="category_id" id="category_id" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Add Product</button>
    </form>
</div>
@endsection
