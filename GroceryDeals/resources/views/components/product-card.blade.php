<div class="card h-100 shadow-sm border-0">
    <!-- Example asset usage for product image -->
    <img src="{{ asset('images/products/default.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
    
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        
        <div class="mb-2">
            <span class="fs-4 fw-bold text-success">${{ number_format($product->price, 2) }}</span>
            
            @if(isset($product->discount) && $product->discount > 0)
                <span class="badge bg-danger ms-2">{{ $product->discount }}% OFF</span>
            @endif
        </div>
        
        <p class="card-text text-muted small">Category: {{ $product->category ?? 'Grocery' }}</p>
    </div>
    
    <div class="card-footer bg-white border-0 pb-3">
        <!-- Named route usage example -->
        <a href="{{ route('products.show', $product->_id ?? $product->id) }}" class="btn btn-outline-success w-100 mb-2">View Deal</a>
        
        <form action="{{ route('cart.add', $product->_id ?? $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary w-100">{{ __('grocery.add_to_cart') }}</button>
        </form>
    </div>
</div>
