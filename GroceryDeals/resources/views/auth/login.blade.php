@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 rounded-xl shadow-sm p-5">
                    <div class="text-center mb-4">
                        <div style="font-size:3rem;">🛒</div>
                        <h2 class="fw-800 mt-2 mb-1" style="font-weight:800;">Welcome Back!</h2>
                        <p class="text-muted mb-0">Sign in to access your cart and deals.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-xl py-3 @error('email') is-invalid @enderror"
                                   placeholder="you@example.com" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Password</label>
                            <input type="password" name="password" class="form-control rounded-xl py-3 @error('password') is-invalid @enderror"
                                   placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-add-cart py-3 w-100" style="font-size:1rem;">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <div class="p-3 rounded-xl mb-3" style="background:#f0fdf4; border:1px dashed #86efac;">
                            <div class="small text-muted mb-1">Demo Account</div>
                            <div class="fw-bold text-success small">demo@grocerydeals.com / password</div>
                        </div>
                        <p class="text-muted small mb-0">Don't have an account?
                            <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">Sign Up Free →</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
