@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Create New Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="original_price" class="form-label">Original Price</label>
            <input type="number" step="0.01" class="form-control" id="original_price" name="original_price" value="{{ old('original_price') }}">
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select Category</option>
                <option value="fruits" {{ old('category') == 'fruits' ? 'selected' : '' }}>Fruits</option>
                <option value="vegetables" {{ old('category') == 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                <option value="dairy" {{ old('category') == 'dairy' ? 'selected' : '' }}>Dairy</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <!-- Example of showing an uploaded image using Storage::url() -->
        {{--
        @if(isset($product) && $product->image)
            <div class="mb-3">
                <p>Current Image:</p>
                <img src="{{ Storage::url($product->image) }}" alt="Product Image" class="img-thumbnail" width="150">
            </div>
        @endif
        --}}

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>
@endsection
