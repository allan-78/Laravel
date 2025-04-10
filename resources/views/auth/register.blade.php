@extends('layouts.app')

@section('content')
<!-- Bootstrap Icons CDN Link -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg login-card">
                <div class="row g-0">
                    <!-- Left sidebar with branding -->
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="h-100 d-flex flex-column" style="background-color: #1d3557;">
                            <div class="p-4 d-flex flex-column justify-content-center align-items-center h-100 text-center">
                                <i class="bi bi-tools text-white mb-4" style="font-size: 4rem;"></i>
                                <h2 class="text-white fw-bold mb-4">EnM Hardware</h2>
                                <p class="text-white-50 mb-4">Join our community of home improvement enthusiasts and professional contractors</p>
                                
                                <div class="login-benefits mt-3 w-100">
                                    <div class="benefit-item text-start text-white mb-3">
                                        <i class="bi bi-check2-circle text-white me-2"></i>
                                        <span>Exclusive member discounts</span>
                                    </div>
                                    <div class="benefit-item text-start text-white mb-3">
                                        <i class="bi bi-check2-circle text-white me-2"></i>
                                        <span>Track orders & purchase history</span>
                                    </div>
                                    <div class="benefit-item text-start text-white mb-3">
                                        <i class="bi bi-check2-circle text-white me-2"></i>
                                        <span>Quick reordering of favorites</span>
                                    </div>
                                    <div class="benefit-item text-start text-white mb-3">
                                        <i class="bi bi-check2-circle text-white me-2"></i>
                                        <span>Early access to promotions</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Registration form -->
                    <div class="col-lg-7">
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex align-items-center mb-4">
                                <div style="width: 5px; height: 30px; background-color: #e63946;" class="me-3"></div>
                                <h3 class="fw-bold m-0">Create Account</h3>
                            </div>
                            
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold">{{ __('Full Name') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-white">
                                            <i class="bi bi-person-fill text-muted"></i>
                                        </span>
                                        <input id="name" type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-white">
                                            <i class="bi bi-envelope-fill text-muted"></i>
                                        </span>
                                        <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="profile_photo" class="form-label fw-semibold">{{ __('Profile Photo') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-white">
                                            <i class="bi bi-camera-fill text-muted"></i>
                                        </span>
                                        <input id="profile_photo" type="file" class="form-control border-start-0 @error('profile_photo') is-invalid @enderror" name="profile_photo">
                                    </div>
                                    @error('profile_photo')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-text small">Optional - Add a profile picture</div>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-white">
                                            <i class="bi bi-lock-fill text-muted"></i>
                                        </span>
                                        <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Choose a strong password">
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password-confirm" class="form-label fw-semibold">{{ __('Confirm Password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0 bg-white">
                                            <i class="bi bi-shield-lock-fill text-muted"></i>
                                        </span>
                                        <input id="password-confirm" type="password" class="form-control border-start-0" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2 fw-semibold">
                                        <i class="bi bi-person-plus-fill me-2"></i>{{ __('Register Now') }}
                                    </button>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <span class="text-muted">Already have an account?</span>
                                    <a href="{{ route('login') }}" class="ms-1 text-decoration-none fw-semibold" style="color: #1d3557;">
                                        Log In <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </div>

                                <div class="mt-4 pt-3 text-center border-top">
                                    <small class="text-muted">By registering, you agree to our <a href="#" style="color: #1d3557;">Terms of Service</a> and <a href="#" style="color: #1d3557;">Privacy Policy</a></small>
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