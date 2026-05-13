@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Product</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $product->name ?? '') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" 
                   name="price" 
                   id="price" 
                   class="form-control @error('price') is-invalid @enderror" 
                   value="{{ old('price', $product->price ?? '') }}">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="original_price" class="form-label">Original Price</label>
            <input type="number" step="0.01" 
                   name="original_price" 
                   id="original_price" 
                   class="form-control @error('original_price') is-invalid @enderror" 
                   value="{{ old('original_price', $product->original_price ?? '') }}">
            @error('original_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                <option value="">Select Category</option>
                <option value="fruits" {{ old('category', $product->category ?? '') == 'fruits' ? 'selected' : '' }}>Fruits</option>
                <option value="vegetables" {{ old('category', $product->category ?? '') == 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                <option value="dairy" {{ old('category', $product->category ?? '') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                <option value="bakery" {{ old('category', $product->category ?? '') == 'bakery' ? 'selected' : '' }}>Bakery</option>
                <option value="beverages" {{ old('category', $product->category ?? '') == 'beverages' ? 'selected' : '' }}>Beverages</option>
                <option value="snacks" {{ old('category', $product->category ?? '') == 'snacks' ? 'selected' : '' }}>Snacks</option>
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" 
                   name="stock" 
                   id="stock" 
                   class="form-control @error('stock') is-invalid @enderror" 
                   value="{{ old('stock', $product->stock ?? '') }}">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image (Leave blank to keep current)</label>
            <input type="file" 
                   name="image" 
                   id="image" 
                   class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
