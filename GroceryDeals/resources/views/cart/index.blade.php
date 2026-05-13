@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<section class="section-pad">
    <div class="container">
        <h1 class="section-title mb-2">Your Cart</h1>
        <p class="text-muted mb-5">Review your items and proceed to checkout.</p>

        @php $cartItems = session('cart', []); $total = 0; @endphp

        @if(count($cartItems) > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 rounded-xl shadow-sm overflow-hidden">
                    <div class="card-body p-0">
                        @foreach($cartItems as $id => $item)
                        @php $itemTotal = $item['price'] * ($item['quantity'] ?? 1); $total += $itemTotal; @endphp
                        <div class="d-flex align-items-center p-4 border-bottom">
                            <div style="width:70px; height:70px; background:linear-gradient(135deg,#d1fae5,#a7f3d0); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:2rem; flex-shrink:0;">
                                🛒
                            </div>
                            <div class="ms-4 flex-grow-1">
                                <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                                <div class="text-success fw-bold">₹{{ number_format($item['price'], 2) }}</div>
                            </div>
                            <div class="d-flex align-items-center gap-3 ms-3">
                                <span class="badge bg-light text-dark border px-3 py-2">Qty: {{ $item['quantity'] ?? 1 }}</span>
                                <div class="fw-bold text-dark">₹{{ number_format($itemTotal, 2) }}</div>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer bg-light p-3 d-flex justify-content-end">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger rounded-pill btn-sm" type="submit">
                                <i class="bi bi-trash me-1"></i>Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 rounded-xl shadow-sm p-4 sticky-top" style="top:100px;">
                    <h5 class="fw-bold mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal ({{ count($cartItems) }} items)</span>
                        <span>₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Delivery</span>
                        <span class="text-success fw-bold">{{ $total >= 499 ? 'FREE' : '₹40.00' }}</span>
                    </div>
                    @if($total < 499)
                        <div class="alert py-2 px-3 mb-2" style="background:#fef9c3; color:#854d0e; border-radius:10px; font-size:0.8rem;">
                            <i class="bi bi-info-circle me-1"></i>Add ₹{{ number_format(499 - $total, 2) }} more for free delivery!
                        </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-success">₹{{ number_format($total + ($total < 499 ? 40 : 0), 2) }}</span>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control border-end-0 rounded-start-pill" placeholder="Promo code">
                            <button class="btn btn-outline-success rounded-end-pill" type="button">Apply</button>
                        </div>
                    </div>
                    <button class="btn btn-add-cart py-3" style="font-size:1rem;">
                        <i class="bi bi-bag-check me-2"></i>Proceed to Checkout
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-link text-muted text-center d-block mt-2 text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>

        @else
        <div class="text-center py-5">
            <div style="font-size:6rem; margin-bottom:1rem;">🛒</div>
            <h3 class="fw-bold mb-2">Your cart is empty</h3>
            <p class="text-muted mb-4">Looks like you haven't added anything yet.</p>
            <a href="{{ route('products.index') }}" class="btn btn-success rounded-pill px-5 py-3">
                <i class="bi bi-bag me-2"></i>Start Shopping
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
