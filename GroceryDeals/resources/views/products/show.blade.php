@extends('layouts.app')

@section('title', $product->name)

@section('content')
<section class="section-pad">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-success text-decoration-none">Products</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5 align-items-start">
            <!-- Product Image -->
            <div class="col-md-5">
                <div class="card border-0 rounded-xl overflow-hidden shadow-sm">
                    @if($product->image_url)
                        <img src="{{ asset($product->image_url) }}" class="img-fluid" alt="{{ $product->name }}">
                    @else
                        <div style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); height: 380px; display:flex; align-items:center; justify-content:center; font-size:9rem;">
                            🛒
                        </div>
                    @endif
                    @if(($product->discount_percentage ?? 0) > 0)
                        <div style="position:absolute; top:16px; left:16px;">
                            <span class="badge-deal">-{{ $product->discount_percentage }}% OFF</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-7">
                <span class="badge-cat mb-3 d-inline-block">{{ ucfirst($product->category ?? 'Fresh') }}</span>
                <h1 class="fw-800 mb-2" style="font-size:2rem; font-weight:800;">{{ $product->name }}</h1>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ ($product->rating ?? 4) >= $i ? '-fill' : '' }}"></i>
                        @endfor
                    </div>
                    <span class="text-muted small">{{ $product->rating ?? 4.2 }} · {{ $product->reviews_count ?? 128 }} reviews</span>
                    @if(($product->stock ?? 0) > 0)
                        <span class="badge bg-success-subtle text-success rounded-pill"><i class="bi bi-check-circle me-1"></i>In Stock</span>
                    @endif
                </div>

                <!-- Price -->
                <div class="mb-4 p-4 rounded-xl" style="background:#f0fdf4; border:1px solid #d1fae5;">
                    @if(($product->discount_percentage ?? 0) > 0)
                        <div class="price-original mb-1">MRP ₹{{ number_format($product->original_price, 2) }}</div>
                        <div class="price-deal" style="font-size:2.2rem;">₹{{ number_format($product->price * (1 - $product->discount_percentage/100), 2) }}</div>
                        <div class="text-success small fw-bold">You save ₹{{ number_format($product->original_price - ($product->price * (1 - $product->discount_percentage/100)), 2) }} ({{ $product->discount_percentage }}%)</div>
                    @else
                        <div class="price-deal" style="font-size:2.2rem;">₹{{ number_format($product->price, 2) }}</div>
                    @endif
                    <div class="text-muted small mt-1">Inclusive of all taxes · Free delivery on orders above ₹499</div>
                </div>

                <!-- Description -->
                <p class="text-muted lh-lg mb-4">{{ $product->description }}</p>

                <!-- Tags -->
                @if(!empty($product->tags))
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @foreach($product->tags as $tag)
                        <span class="badge-cat">{{ $tag }}</span>
                    @endforeach
                </div>
                @endif

                <!-- Actions -->
                <div class="d-flex gap-3">
                    @auth
                        <form action="{{ route('cart.add', $product->_id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            <button type="submit" class="btn btn-add-cart py-3" style="font-size:1rem;">
                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-add-cart py-3 flex-grow-1" style="font-size:1rem;">
                            <i class="bi bi-cart-plus me-2"></i>Add to Cart
                        </a>
                    @endauth
                    <button class="btn btn-outline-secondary rounded-xl px-4" title="Add to Wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>

                <!-- Guarantees -->
                <div class="row g-3 mt-4">
                    @foreach([['bi-shield-check','100% Fresh','Freshness guaranteed or full refund'],['bi-truck','Free Delivery','On orders above ₹499'],['bi-arrow-counterclockwise','Easy Returns','7-day hassle-free returns']] as $g)
                    <div class="col-4">
                        <div class="text-center p-3 rounded-xl" style="background:white; border:1px solid #e5e7eb;">
                            <i class="bi {{ $g[0] }} text-success fs-4 d-block mb-1"></i>
                            <div class="fw-bold small">{{ $g[1] }}</div>
                            <div class="text-muted" style="font-size:0.7rem;">{{ $g[2] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
