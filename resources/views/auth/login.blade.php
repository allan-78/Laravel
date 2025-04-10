@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="login-card card shadow-lg border-0">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0"><i class="fas fa-sign-in-alt me-2"></i>{{ __('Login to EnM Hardware') }}</h4>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-5 d-none d-md-block">
                            <div class="login-sidebar text-center">
                                <div class="mb-4">
                                    <i class="fas fa-tools login-icon"></i>
                                </div>
                                <h5 class="mb-3">Welcome Back!</h5>
                                <p class="text-muted">Access your account to view orders, manage your profile, and continue shopping.</p>
                                <div class="login-benefits mt-4">
                                    <div class="benefit-item">
                                        <i class="fas fa-box"></i>
                                        <span>Track Orders</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-history"></i>
                                        <span>Order History</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="fas fa-heart"></i>
                                        <span>Saved Items</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold">{{ __('Email Address') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback d-block mt-1" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback d-block mt-1" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login') }}
                                    </button>
                                </div>

                                <div class="mt-3 text-center">
                                    @if (Route::has('password.request'))
                                        <a class="text-decoration-none" href="{{ route('password.request') }}">
                                            <i class="fas fa-question-circle me-1"></i>{{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                
                                <div class="mt-4 text-center">
                                    <p class="mb-0">Don't have an account? 
                                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Register</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .login-card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .card-header {
        background-color: #1d3557 !important;
        padding: 1rem;
    }
    
    .login-sidebar {
        height: 100%;
        padding: 1.5rem 1rem;
        border-right: 1px solid #e9ecef;
    }
    
    .login-icon {
        font-size: 3.5rem;
        color: #e63946;
        margin-bottom: 1rem;
    }
    
    .login-benefits {
        text-align: left;
    }
    
    .benefit-item {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    
    .benefit-item i {
        margin-right: 10px;
        color: #1d3557;
        width: 20px;
    }
    
    .btn-primary {
        background-color: #e63946;
        border-color: #e63946;
    }
    
    .btn-primary:hover {
        background-color: #d62939;
        border-color: #d62939;
    }
    
    .input-group-text {
        border-right: none;
    }
    
    .form-control {
        border-left: none;
    }
    
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    
    .form-check-input:checked {
        background-color: #e63946;
        border-color: #e63946;
    }
    
    a {
        color: #1d3557;
    }
    
    a:hover {
        color: #e63946;
    }
    
    @media (max-width: 767px) {
        .card-body {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endsection