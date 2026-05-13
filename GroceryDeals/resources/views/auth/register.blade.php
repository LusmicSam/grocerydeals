@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 rounded-xl shadow-sm p-5">
                    <div class="text-center mb-4">
                        <div style="font-size:3rem;">🌿</div>
                        <h2 class="fw-800 mt-2 mb-1" style="font-weight:800;">Join GroceryDeals</h2>
                        <p class="text-muted mb-0">Get access to exclusive deals and your personal cart.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Full Name</label>
                            <input type="text" name="name" class="form-control rounded-xl py-3 @error('name') is-invalid @enderror"
                                   placeholder="Your full name" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-xl py-3 @error('email') is-invalid @enderror"
                                   placeholder="you@example.com" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Password</label>
                            <input type="password" name="password" class="form-control rounded-xl py-3"
                                   placeholder="Min 8 characters" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control rounded-xl py-3"
                                   placeholder="Repeat password" required>
                        </div>
                        <button type="submit" class="btn btn-add-cart py-3 w-100" style="font-size:1rem;">
                            <i class="bi bi-person-plus me-2"></i>Create Account
                        </button>
                    </form>

                    <p class="text-center text-muted small mt-4 mb-0">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">Sign In →</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
