@extends('layouts.app')

@section('title', 'All Products')

@section('styles')
<style>
/* Pagination Bootstrap 5 — green theme */
.pagination { gap: 4px; }
.page-link {
    border-radius: 50px !important;
    border: 1px solid var(--border2);
    color: var(--primary);
    background: var(--card-bg);
    padding: 6px 14px;
    font-weight: 600;
    transition: all 0.2s;
}
.page-link:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
.page-item.active .page-link { background: var(--primary); border-color: var(--primary); color: #fff; }
.page-item.disabled .page-link { background: var(--card-bg); color: var(--text-muted); }
</style>
@endsection

@section('content')
<section class="section-pad">
    <div class="container">
        <div class="row mb-5 align-items-end fade-up">
            <div class="col-md-6">
                <h1 class="section-title mb-2">{{ __('grocery.our_catalog') }}</h1>
                <p style="color:var(--text-muted);" class="mb-0">{{ __('grocery.catalog_sub') }}</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex gap-2">
                    <a href="{{ route('lang.switch', 'en') }}" class="btn btn-sm btn-outline-success rounded-pill {{ app()->getLocale() == 'en' ? 'active' : '' }}">🇬🇧 English</a>
                    <a href="{{ route('lang.switch', 'hi') }}" class="btn btn-sm btn-outline-success rounded-pill {{ app()->getLocale() == 'hi' ? 'active' : '' }}">🇮🇳 हिंदी</a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="filter-card card border-0 rounded-xl shadow-sm p-4 sticky-top" style="top: 90px;">
                    <h5 class="fw-bold mb-4">🏷️ {{ __('grocery.categories') }}</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('products.index') }}" class="cat-link {{ !request('category') ? 'active-cat' : '' }}">
                                <i class="bi bi-grid me-2 small"></i>{{ __('grocery.all_products') }}
                            </a>
                        </li>
                        @foreach([
                            'fruits'     => '🍎 Fruits',
                            'vegetables' => '🥦 Vegetables',
                            'dairy'      => '🧀 Dairy',
                            'bakery'     => '🍞 Bakery',
                            'meat'       => '🥩 Meat',
                            'beverages'  => '🧃 Beverages',
                            'snacks'     => '🍿 Snacks',
                        ] as $slug => $label)
                        <li class="mb-2">
                            <a href="{{ route('products.index') }}?category={{ $slug }}" class="cat-link {{ request('category') == $slug ? 'active-cat' : '' }}">
                                <i class="bi bi-chevron-right me-2 small"></i>{{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <hr class="my-4" style="opacity: 0.15;">

                    <h5 class="fw-bold mb-3">💰 {{ __('grocery.price_range') }}</h5>
                    <input type="range" class="form-range" min="0" max="1000" step="50" id="priceRange" oninput="document.getElementById('priceVal').textContent='₹'+this.value">
                    <div class="d-flex justify-content-between small" style="color:var(--text-muted);">
                        <span>₹0</span>
                        <span id="priceVal">₹1000+</span>
                    </div>

                    <hr class="my-4" style="opacity: 0.15;">

                    <h5 class="fw-bold mb-3">⭐ {{ __('grocery.min_rating') }}</h5>
                    <div class="d-flex gap-1">
                        @for($r=1;$r<=5;$r++)
                        <span class="stars" style="cursor:pointer; font-size:1.2rem;"><i class="bi bi-star-fill"></i></span>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                @php
                $categoryImages = [
                    'fruits'     => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=400&h=250&fit=crop',
                    'vegetables' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&h=250&fit=crop',
                    'dairy'      => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=400&h=250&fit=crop',
                    'bakery'     => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=250&fit=crop',
                    'meat'       => 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=400&h=250&fit=crop',
                    'beverages'  => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=400&h=250&fit=crop',
                    'snacks'     => 'https://images.unsplash.com/photo-1555949258-eb67b1ef0ceb?w=400&h=250&fit=crop',
                ];
                $defaultImage = 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=400&h=250&fit=crop';
                @endphp

                @if($products->count() > 0)
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                        @foreach ($products as $product)
                            <div class="col fade-up">
                                <div class="product-card card">
                                    @php
                                        $imgUrl = $product->image_url ?? ($categoryImages[$product->category ?? ''] ?? $defaultImage);
                                    @endphp
                                    <img src="{{ $imgUrl }}" class="card-img-top" alt="{{ $product->name }}" loading="lazy" onerror="this.src='{{ $defaultImage }}'">
                                    <div class="card-body d-flex flex-column p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <span class="badge-cat">{{ ucfirst($product->category ?? 'Fresh') }}</span>
                                            @if(($product->discount_percentage ?? 0) > 0)
                                                <span class="badge-deal">-{{ $product->discount_percentage }}%</span>
                                            @endif
                                        </div>
                                        <h6 class="fw-bold mt-2 mb-1" style="font-size:0.95rem;">{{ $product->name }}</h6>
                                        <p style="color:var(--text-muted); font-size:0.8rem;" class="mb-2">{{ Str::limit($product->description, 60) }}</p>
                                        <!-- Rating -->
                                        <div class="stars mb-2">
                                            @for($s=1;$s<=5;$s++)
                                                <i class="bi bi-star{{ $s <= round($product->rating ?? 4) ? '-fill' : '' }}"></i>
                                            @endfor
                                            <span style="color:var(--text-muted); font-size:0.75rem;" class="ms-1">({{ $product->reviews_count ?? 0 }})</span>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="mb-2">
                                                @if(($product->discount_percentage ?? 0) > 0)
                                                    <span class="price-original">₹{{ number_format($product->price, 2) }}</span><br>
                                                    <span class="price-deal">₹{{ number_format($product->price * (1 - $product->discount_percentage/100), 2) }}</span>
                                                @else
                                                    <span class="price-deal">₹{{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            @auth
                                                <form action="{{ route('cart.add', $product->_id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-add-cart">
                                                        <i class="bi bi-cart-plus me-1"></i> {{ __('grocery.add_to_cart') }}
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-add-cart">
                                                    <i class="bi bi-cart-plus me-1"></i> {{ __('grocery.add_to_cart') }}
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-5 fade-up">
                        <div class="display-1 mb-4">🛒</div>
                        <h3>{{ __('grocery.no_products') }}</h3>
                        <p style="color:var(--text-muted);">Try adjusting your filters or category.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-success rounded-pill mt-3">{{ __('grocery.reset_filters') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
