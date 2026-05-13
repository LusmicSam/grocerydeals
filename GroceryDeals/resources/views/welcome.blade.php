@extends('layouts.app')

@section('title', 'Fresh Grocery Deals')

@section('hero')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-badge"><i class="bi bi-lightning-fill me-1"></i> Daily Deals Updated</div>
                <h1>Fresh Groceries,<br><span>Unbeatable Prices</span></h1>
                <p class="lead mt-3 mb-4" style="opacity:0.9; font-size:1.15rem;">
                    Discover incredible deals on fresh produce, pantry staples, dairy, bakery, meat and everyday essentials. Save up to 60% every day.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('products.index') }}" class="btn btn-hero-primary" id="step-hero-shop">
                        <i class="bi bi-bag-fill me-2"></i>Shop Now
                    </a>
                    <a href="{{ route('deals.index') }}" class="btn btn-hero-outline">
                        <i class="bi bi-tag me-2"></i>View Deals
                    </a>
                </div>
                <div class="d-flex flex-wrap gap-3 mt-2">
                    <span class="stats-pill"><i class="bi bi-box-seam me-1"></i> 500+ Products</span>
                    <span class="stats-pill"><i class="bi bi-truck me-1"></i> Fast Delivery</span>
                    <span class="stats-pill"><i class="bi bi-shield-check me-1"></i> Fresh Guarantee</span>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                <div style="position: relative; width: 340px; height: 340px;">
                    <!-- Orbiting product images -->
                    <img src="https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=120&h=120&fit=crop" alt="Fruits" style="position:absolute; top:0; left:50%; transform:translateX(-50%); width:90px; height:90px; border-radius:50%; object-fit:cover; border:4px solid rgba(255,255,255,0.4); animation:orbit1 4s ease-in-out infinite;">
                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=120&h=120&fit=crop" alt="Dairy" style="position:absolute; bottom:20px; right:0; width:80px; height:80px; border-radius:50%; object-fit:cover; border:4px solid rgba(255,255,255,0.4); animation:orbit2 4s ease-in-out infinite;">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=120&h=120&fit=crop" alt="Bakery" style="position:absolute; bottom:20px; left:0; width:80px; height:80px; border-radius:50%; object-fit:cover; border:4px solid rgba(255,255,255,0.4); animation:orbit3 4s ease-in-out infinite;">
                    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); font-size:7rem; line-height:1; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.2)); animation: float 3s ease-in-out infinite;">🛒</div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
@keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }
@keyframes orbit1 { 0%, 100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(-12px); } }
@keyframes orbit2 { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(12px); } }
@keyframes orbit3 { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
</style>
@endsection

@section('content')

<!-- Category Filter -->
<section class="section-pad pb-2" id="step-categories" data-intro="Filter products by category using these quick pills." data-step="8">
    <div class="container">
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-2">
            <a href="{{ route('products.index') }}" class="cat-pill active"><i class="bi bi-grid me-1"></i>All</a>
            <a href="{{ route('products.index') }}?category=fruits" class="cat-pill">🍎 Fruits</a>
            <a href="{{ route('products.index') }}?category=vegetables" class="cat-pill">🥦 Vegetables</a>
            <a href="{{ route('products.index') }}?category=dairy" class="cat-pill">🧀 Dairy</a>
            <a href="{{ route('products.index') }}?category=bakery" class="cat-pill">🍞 Bakery</a>
            <a href="{{ route('products.index') }}?category=meat" class="cat-pill">🥩 Meat</a>
            <a href="{{ route('products.index') }}?category=beverages" class="cat-pill">🧃 Beverages</a>
            <a href="{{ route('products.index') }}?category=snacks" class="cat-pill">🍿 Snacks</a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section-pad pt-3" id="step-featured">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 fade-up">
            <div>
                <h2 class="section-title mb-0">🔥 Hot Deals Today</h2>
                <p style="color:var(--text-muted);" class="mb-0">Limited time offers on fresh products</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-success rounded-pill px-4">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @php
        /* Real Unsplash images keyed by category */
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

        @if(isset($products) && $products->count() > 0)
            <div class="row g-4">
                @foreach($products->take(8) as $product)
                <div class="col-6 col-md-4 col-lg-3 fade-up">
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
                            <p style="color:var(--text-muted); font-size:0.8rem;" class="mb-2">{{ Str::limit($product->description ?? '', 50) }}</p>
                            <!-- Star Rating -->
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
                                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-add-cart">
                                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Placeholder cards with real images when DB is not seeded -->
            @php
            $placeholders = [
                ['cat'=>'fruits',     'name'=>'Fresh Red Apples (1 kg)',    'price'=>149, 'original'=>199, 'disc'=>25, 'desc'=>'Crisp Shimla apples from Himachal Pradesh orchards.'],
                ['cat'=>'vegetables', 'name'=>'Organic Baby Spinach (250g)', 'price'=>49,  'original'=>69,  'disc'=>29, 'desc'=>'Triple-washed, ready-to-use baby spinach leaves.'],
                ['cat'=>'dairy',      'name'=>'Greek Yogurt (400g)',         'price'=>129, 'original'=>159, 'disc'=>19, 'desc'=>'Thick probiotic-rich yogurt, high in protein.'],
                ['cat'=>'bakery',     'name'=>'Butter Croissants (2 pcs)',   'price'=>99,  'original'=>129, 'disc'=>23, 'desc'=>'Flaky, buttery French croissants baked fresh daily.'],
                ['cat'=>'meat',       'name'=>'Chicken Breast (500g)',       'price'=>299, 'original'=>379, 'disc'=>21, 'desc'=>'Boneless, skinless fresh chicken. Lean & high-protein.'],
                ['cat'=>'beverages',  'name'=>'Fresh Orange Juice (1L)',     'price'=>129, 'original'=>159, 'disc'=>19, 'desc'=>'Cold-pressed, 100% natural with no added sugar.'],
                ['cat'=>'snacks',     'name'=>'Dark Chocolate (100g)',       'price'=>199, 'original'=>249, 'disc'=>20, 'desc'=>'70% dark chocolate from single-origin cocoa beans.'],
                ['cat'=>'dairy',      'name'=>'Amul Butter (500g)',          'price'=>249, 'original'=>275, 'disc'=>9,  'desc'=>'The iconic Amul butter – salted, creamy and perfect.'],
            ];
            @endphp
            <div class="row g-4">
                @foreach($placeholders as $item)
                <div class="col-6 col-md-4 col-lg-3 fade-up">
                    <div class="product-card card">
                        <img src="{{ $categoryImages[$item['cat']] }}" class="card-img-top" alt="{{ $item['name'] }}" loading="lazy">
                        <div class="card-body d-flex flex-column p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="badge-cat">{{ ucfirst($item['cat']) }}</span>
                                <span class="badge-deal">-{{ $item['disc'] }}%</span>
                            </div>
                            <h6 class="fw-bold mt-2 mb-1" style="font-size:0.95rem;">{{ $item['name'] }}</h6>
                            <p style="color:var(--text-muted); font-size:0.8rem;" class="mb-2">{{ $item['desc'] }}</p>
                            <div class="stars mb-2">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                <span style="color:var(--text-muted); font-size:0.75rem;" class="ms-1">(42)</span>
                            </div>
                            <div class="mt-auto">
                                <div class="mb-2">
                                    <span class="price-original">₹{{ $item['original'] }}.00</span><br>
                                    <span class="price-deal">₹{{ $item['price'] }}.00</span>
                                </div>
                                <a href="{{ route('login') }}" class="btn btn-add-cart">
                                    <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Promo Banner -->
<section class="container mb-5 fade-up">
    <div class="promo-banner d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <div>
            <h3 class="fw-bold mb-1" style="font-weight:800;">🎉 First Order? Get 20% Off!</h3>
            <p class="mb-0" style="opacity:0.9;">Use code <strong>FRESH20</strong> at checkout. Valid on orders above ₹500.</p>
        </div>
        <a href="{{ route('register') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold flex-shrink-0">
            Claim Offer <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</section>

<!-- Why Us -->
<section class="section-pad bg-section">
    <div class="container">
        <h2 class="section-title text-center mb-2 fade-up">Why GroceryDeals?</h2>
        <p class="text-center mb-5 fade-up" style="color:var(--text-muted);">We make fresh groceries accessible and affordable for everyone</p>
        <div class="row g-4 text-center">
            @foreach([
                ['🌿','Always Fresh','Every product sourced daily from local farms and trusted suppliers.'],
                ['💰','Best Prices','We compare prices so you always get the best deal in town.'],
                ['⚡','Fast Delivery','Express delivery options to your doorstep within 2 hours.'],
                ['🔒','Secure Shopping','Your data and payments are fully protected and encrypted.'],
            ] as $feat)
            <div class="col-6 col-md-3 fade-up">
                <div class="feature-card p-4 h-100">
                    <div style="font-size:2.5rem; margin-bottom:0.75rem;">{{ $feat[0] }}</div>
                    <h6 class="fw-bold mb-2">{{ $feat[1] }}</h6>
                    <p style="color:var(--text-muted);" class="small mb-0">{{ $feat[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Category Showcase -->
<section class="section-pad">
    <div class="container">
        <h2 class="section-title text-center mb-2 fade-up">Shop by Category</h2>
        <p class="text-center mb-5 fade-up" style="color:var(--text-muted);">Everything you need, all in one place</p>
        <div class="row g-3">
            @php
            $cats = [
                ['fruits',     '🍎', 'Fruits',     '#ef4444', 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=300&h=180&fit=crop'],
                ['vegetables', '🥦', 'Vegetables', '#16a34a', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300&h=180&fit=crop'],
                ['dairy',      '🥛', 'Dairy',      '#3b82f6', 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=300&h=180&fit=crop'],
                ['bakery',     '🍞', 'Bakery',     '#f59e0b', 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=300&h=180&fit=crop'],
                ['meat',       '🥩', 'Meat',       '#dc2626', 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=300&h=180&fit=crop'],
                ['beverages',  '🧃', 'Beverages',  '#06b6d4', 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=300&h=180&fit=crop'],
                ['snacks',     '🍿', 'Snacks',     '#8b5cf6', 'https://images.unsplash.com/photo-1555949258-eb67b1ef0ceb?w=300&h=180&fit=crop'],
                ['all',        '🛒', 'All Items',  '#15803d', 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=300&h=180&fit=crop'],
            ];
            @endphp
            @foreach($cats as [$slug, $icon, $label, $color, $img])
            <div class="col-6 col-md-3 fade-up">
                <a href="{{ route('products.index') }}{{ $slug !== 'all' ? '?category='.$slug : '' }}" class="text-decoration-none">
                    <div style="border-radius:16px; overflow:hidden; position:relative; height:150px; box-shadow:var(--shadow); transition:all 0.3s;" class="cat-showcase">
                        <img src="{{ $img }}" alt="{{ $label }}" style="width:100%; height:100%; object-fit:cover;">
                        <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.1) 100%);"></div>
                        <div style="position:absolute; bottom:12px; left:14px; color:white;">
                            <div style="font-size:1.6rem;">{{ $icon }}</div>
                            <div style="font-weight:700; font-size:0.95rem;">{{ $label }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<style>
.cat-showcase:hover { transform: translateY(-5px) scale(1.02); box-shadow: var(--shadow-hover) !important; }
</style>

@endsection
