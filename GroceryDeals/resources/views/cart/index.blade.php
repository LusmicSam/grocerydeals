@extends('layouts.app')

@section('title', 'Your Cart')

@section('styles')
<style>
.cart-item-img {
    width: 72px; height: 72px;
    border-radius: 12px; object-fit: cover; flex-shrink: 0;
}
.cart-img-placeholder {
    width: 72px; height: 72px; border-radius: 12px; flex-shrink: 0;
    background: var(--placeholder-bg);
    display: flex; align-items: center; justify-content: center; font-size: 2rem;
}
.cart-item-row {
    background: var(--card-bg);
    border-bottom: 1px solid var(--border2);
}
.cart-item-row:last-child { border-bottom: none; }
.summary-card { background: var(--card-bg); border: 1px solid var(--border2); border-radius: 16px; }
.qty-badge {
    background: var(--bg); border: 1px solid var(--border2);
    color: var(--text); border-radius: 50px; padding: 4px 14px; font-weight: 700;
}
.free-delivery { background: #fef9c3; color: #854d0e; border-radius: 10px; font-size: 0.82rem; }
[data-theme="dark"] .free-delivery { background: #422006; color: #fde68a; }
</style>
@endsection

@section('content')
<section class="section-pad">
    <div class="container">
        <div class="fade-up">
            <h1 class="section-title mb-1">🛒 Your Cart</h1>
            <p style="color:var(--text-muted);" class="mb-5">Review your items and proceed to checkout.</p>
        </div>

        @php
            $cartItems = $cart ?? [];
            $total     = $total ?? 0;
            $delivery  = $total >= 499 ? 0 : 40;
        @endphp

        @if(count($cartItems) > 0)
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8 fade-up">
                <div class="card border-0 rounded-xl shadow-sm overflow-hidden" style="background: var(--card-bg);">
                    <div class="card-body p-0">
                        @foreach($cartItems as $id => $item)
                        <div class="d-flex align-items-center p-4 cart-item-row">
                            <!-- Product Image -->
                            @if(!empty($item['image']))
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] ?? 'Product' }}"
                                     class="cart-item-img"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="cart-img-placeholder" style="display:none;">🛒</div>
                            @else
                                <div class="cart-img-placeholder">🛒</div>
                            @endif

                            <!-- Product Info -->
                            <div class="ms-4 flex-grow-1">
                                <h6 class="fw-bold mb-1">{{ $item['name'] ?? 'Unknown Product' }}</h6>
                                <span class="badge-cat">{{ ucfirst($item['category'] ?? 'Fresh') }}</span>
                                <div class="price-deal mt-1" style="font-size:1rem;">
                                    ₹{{ number_format($item['price'] ?? 0, 2) }}
                                    <span style="color:var(--text-muted); font-size:0.75rem; font-weight:400;">per unit</span>
                                </div>
                            </div>

                            <!-- Qty + Total + Remove -->
                            <div class="d-flex align-items-center gap-3 ms-3 flex-shrink-0">
                                <span class="qty-badge">× {{ $item['quantity'] ?? 1 }}</span>
                                <div class="fw-bold" style="min-width:80px; text-align:right;">
                                    ₹{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}
                                </div>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" type="submit" title="Remove">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end p-3" style="border-top: 1px solid var(--border2); background: var(--card-bg);">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger rounded-pill btn-sm" type="submit">
                                <i class="bi bi-trash me-1"></i>Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4 fade-up">
                <div class="summary-card p-4 sticky-top" style="top: 90px;">
                    <h5 class="fw-bold mb-4">Order Summary</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span style="color:var(--text-muted);">Subtotal ({{ count($cartItems) }} items)</span>
                        <span>₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span style="color:var(--text-muted);">Delivery</span>
                        <span class="{{ $delivery == 0 ? 'text-success' : '' }} fw-bold">
                            {{ $delivery == 0 ? 'FREE 🎉' : '₹40.00' }}
                        </span>
                    </div>

                    @if($delivery > 0)
                    <div class="free-delivery p-2 mb-3">
                        <i class="bi bi-info-circle me-1"></i>Add ₹{{ number_format(499 - $total, 2) }} more for free delivery!
                    </div>
                    @endif

                    <hr style="border-color: var(--border2);">

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5" style="color: var(--primary);">₹{{ number_format($total + $delivery, 2) }}</span>
                    </div>

                    <!-- Promo Code -->
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control border-end-0 rounded-start-pill"
                                   placeholder="Promo code (e.g. FRESH20)"
                                   style="background:var(--input-bg); color:var(--input-text); border-color:var(--input-border);">
                            <button class="btn btn-outline-success rounded-end-pill fw-bold" type="button">Apply</button>
                        </div>
                    </div>

                    <button class="btn btn-add-cart py-3" style="font-size:1rem; font-weight:700;">
                        <i class="bi bi-bag-check me-2"></i>Proceed to Checkout
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-link d-block mt-2 text-center text-decoration-none small" style="color:var(--text-muted);">
                        <i class="bi bi-arrow-left me-1"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>

        @else
        <!-- Empty Cart -->
        <div class="text-center py-5 fade-up">
            <div style="font-size:6rem; margin-bottom:1rem; animation: float 3s ease-in-out infinite;">🛒</div>
            <h3 class="fw-bold mb-2">Your cart is empty</h3>
            <p style="color:var(--text-muted);" class="mb-4">Looks like you haven't added anything yet. Let's fix that!</p>
            <a href="{{ route('products.index') }}" class="btn btn-success rounded-pill px-5 py-3 fw-bold">
                <i class="bi bi-bag me-2"></i>Start Shopping
            </a>
        </div>
        <style>@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }</style>
        @endif
    </div>
</section>
@endsection
