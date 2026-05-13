@extends('layouts.app')

@section('title', 'Deals & Offers')

@section('hero')
<section style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%); color:white; padding: 3.5rem 0 3rem; position:relative; overflow:hidden;">
    <div style="position:absolute; top:-40%; right:-5%; width:500px; height:500px; background:rgba(255,255,255,0.03); border-radius:50%;"></div>
    <div class="container text-center" style="position:relative;">
        <div style="font-size:3rem; margin-bottom:0.5rem;">🏷️</div>
        <h1 class="fw-bold mb-2" style="font-size:2.5rem; font-weight:800;">Today's Best Deals</h1>
        <p class="mb-0" style="opacity:0.85; font-size:1.05rem;">Limited-time offers on fresh groceries. Grab them before they're gone!</p>
    </div>
</section>
@endsection

@section('content')

@php
/* Per-category fallback images */
$categoryImages = [
    'fruits'     => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=400&h=200&fit=crop',
    'vegetables' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=200&fit=crop',
    'dairy'      => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=400&h=200&fit=crop',
    'bakery'     => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=200&fit=crop',
    'meat'       => 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=400&h=200&fit=crop',
    'beverages'  => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=400&h=200&fit=crop',
    'snacks'     => 'https://images.unsplash.com/photo-1555949258-eb67b1ef0ceb?w=400&h=200&fit=crop',
];
$defaultImage = 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=400&h=200&fit=crop';
@endphp

<section class="section-pad">
    <div class="container">
        @if(isset($deals) && $deals->count() > 0)
            @foreach($deals as $deal)
            <div class="mb-5 fade-up">
                <!-- Deal Banner -->
                <div class="d-flex align-items-center justify-content-between p-4 rounded-xl mb-4"
                     style="background: linear-gradient(135deg, {{ $deal->banner_color ?? '#16a34a' }}22, {{ $deal->banner_color ?? '#16a34a' }}11);
                            border: 2px solid {{ $deal->banner_color ?? '#16a34a' }}55;">
                    <div>
                        <h2 class="fw-bold mb-1" style="font-weight:800; font-size:1.5rem;">{{ $deal->title }}</h2>
                        <p style="color:var(--text-muted);" class="mb-0">{{ $deal->description }}</p>
                    </div>
                    <div class="text-end flex-shrink-0 ms-4">
                        <div style="font-size:2.5rem; font-weight:900; color:{{ $deal->banner_color ?? '#16a34a' }}; line-height:1;">{{ $deal->discount_percent }}%</div>
                        <div class="small fw-bold" style="color:var(--text-muted);">OFF</div>
                        @if($deal->expires_at)
                            <div class="small text-danger mt-1">
                                <i class="bi bi-clock me-1"></i>Ends {{ \Carbon\Carbon::parse($deal->expires_at)->diffForHumans() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Deal Products with real images -->
                @php $dealProducts = \App\Models\Product::whereIn('_id', $deal->product_ids ?? [])->get(); @endphp
                @if($dealProducts->count() > 0)
                <div class="row g-4">
                    @foreach($dealProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card card h-100">
                            @php
                                $imgUrl = $product->image_url
                                    ?? ($categoryImages[$product->category ?? ''] ?? $defaultImage);
                            @endphp
                            <img src="{{ $imgUrl }}"
                                 class="card-img-top"
                                 alt="{{ $product->name }}"
                                 style="height:160px; object-fit:cover;"
                                 loading="lazy"
                                 onerror="this.src='{{ $defaultImage }}'">
                            <div class="card-body d-flex flex-column p-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="badge-cat">{{ ucfirst($product->category ?? 'Fresh') }}</span>
                                    <span class="badge-deal">-{{ $deal->discount_percent }}%</span>
                                </div>
                                <h6 class="fw-bold mt-2 mb-1" style="font-size:0.9rem;">{{ $product->name }}</h6>
                                <p style="color:var(--text-muted); font-size:0.78rem;" class="mb-2">{{ Str::limit($product->description ?? '', 50) }}</p>
                                <!-- Star Rating -->
                                <div class="stars mb-2" style="font-size:0.75rem;">
                                    @for($s=1;$s<=5;$s++)
                                        <i class="bi bi-star{{ $s <= round($product->rating ?? 4) ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <div class="mt-auto pt-1">
                                    <span class="price-original">₹{{ number_format($product->price, 2) }}</span><br>
                                    <span class="price-deal">₹{{ number_format($product->price * (1 - $deal->discount_percent/100), 2) }}</span>
                                    <div class="mt-2">
                                        @auth
                                            <form action="{{ route('cart.add', $product->_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-add-cart">
                                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-add-cart">
                                                <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(!$loop->last)
                    <hr class="my-5" style="border-color: var(--border2);">
                @endif
            </div>
            @endforeach
        @else
            <div class="text-center py-5 fade-up">
                <div class="display-1 mb-4">🏷️</div>
                <h3>No Active Deals Right Now</h3>
                <p style="color:var(--text-muted);">Check back soon – we update our deals daily!</p>
                <a href="{{ route('products.index') }}" class="btn btn-success rounded-pill mt-3 px-4">Browse All Products</a>
            </div>
        @endif
    </div>
</section>
@endsection
