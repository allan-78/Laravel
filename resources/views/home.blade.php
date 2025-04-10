@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Search Bar Section - Prominent placement at top -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <form action="{{ route('home') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="q" placeholder="{{ __('Search products...') }}" value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search me-1"></i> {{ __('Search') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results Section - Only shown when search is performed -->
    @if(request('q'))
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Search Results for') }}: "{{ request('q') }}"</span>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">{{ __('Clear Search') }}</a>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="row g-4">
                            @foreach($products as $product)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                            <p class="fw-bold">${{ number_format($product->price, 2) }}</p>
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary mt-2">{{ __('View Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p class="mb-0 text-center">{{ __('No products found matching') }} "{{ request('q') }}". {{ __('Try a different search term.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content Section - Only shown when not searching -->
    @if(!request('q'))
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Welcome to Hardware Store') }}</div>

                <div class="card-body p-0">
                    @if (session('status'))
                        <div class="alert alert-success m-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (auth()->user() && !auth()->user()->hasVerifiedEmail())
                        <div class="alert alert-warning m-3" role="alert">
                            <h4>{{ __('Please verify your email first') }}</h4>
                            <p>{{ __('You need to verify your email address before accessing all features.') }}</p>
                            
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <p>{{ __('Check your email for the verification link we sent.') }}</p>
                            <p>{{ __('If you didn\'t receive the email') }},</p>
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="container-fluid px-0">
                            <!-- Hero Section -->
                            <div class="hero-section bg-dark text-white py-5 mb-5" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1600585152220-90363fe7e115') center/cover no-repeat;">
                                <div class="container py-5">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h1 class="display-4 fw-bold mb-4">{{ __('Quality Tools for Every Project') }}</h1>
                                            <p class="lead mb-4">{{ __('Discover our premium selection of hardware tools and equipment') }}</p>
                                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 me-2">
                                                <i class="bi bi-tools me-2"></i>{{ __('Shop Now') }}
                                            </a>
                                            <a href="#" class="btn btn-outline-light btn-lg px-4">
                                                <i class="bi bi-info-circle me-2"></i>{{ __('Learn More') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Products -->
                            <div class="container mb-5">
                                <h2 class="text-center mb-4">{{ __('Featured Products') }}</h2>
                                <div class="row g-4">
                                    @foreach($products as $product)
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                <p class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                                <p class="fw-bold">${{ number_format($product->price, 2) }}</p>
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary mt-2">{{ __('View Details') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Special Offers -->
                            <div class="bg-light py-5 mb-5">
                                <div class="container">
                                    <h2 class="text-center mb-4">{{ __('Special Offers') }}</h2>
                                    <div class="row">
                                        <div class="col-md-6 mb-4 mb-md-0">
                                            <div class="card border-0 shadow">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 bg-danger text-white rounded-circle p-3 me-3">
                                                            <i class="bi bi-lightning-charge fs-2"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-1">{{ __('Flash Sale') }}</h5>
                                                            <p class="mb-0 text-muted">{{ __('Limited time offers on selected items') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border-0 shadow">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 bg-success text-white rounded-circle p-3 me-3">
                                                            <i class="bi bi-star-fill fs-2"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-1">{{ __('New Arrivals') }}</h5>
                                                            <p class="mb-0 text-muted">{{ __('Check out our latest products') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Testimonials -->
                            <div class="container mb-5">
                                <h2 class="text-center mb-4">{{ __('What Our Customers Say') }}</h2>
                                <div class="row">
                                    <div class="col-md-4 mb-4 mb-md-0">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-body text-center p-4">
                                                <div class="mb-3">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                </div>
                                                <p class="mb-4">"{{ __('Great quality tools at affordable prices. Highly recommended!') }}"</p>
                                                <div class="d-flex justify-content-center">
                                                    <div class="avatar bg-primary rounded-circle me-3" style="width: 40px; height: 40px;"></div>
                                                    <div class="text-start">
                                                        <h6 class="mb-0">John D.</h6>
                                                        <small class="text-muted">{{ __('Professional Carpenter') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4 mb-md-0">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-body text-center p-4">
                                                <div class="mb-3">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                </div>
                                                <p class="mb-4">"{{ __('Excellent customer service and fast delivery. Will shop again!') }}"</p>
                                                <div class="d-flex justify-content-center">
                                                    <div class="avatar bg-primary rounded-circle me-3" style="width: 40px; height: 40px;"></div>
                                                    <div class="text-start">
                                                        <h6 class="mb-0">Sarah M.</h6>
                                                        <small class="text-muted">{{ __('DIY Enthusiast') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-body text-center p-4">
                                                <div class="mb-3">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                </div>
                                                <p class="mb-4">"{{ __('Best hardware store in town with knowledgeable staff.') }}"</p>
                                                <div class="d-flex justify-content-center">
                                                    <div class="avatar bg-primary rounded-circle me-3" style="width: 40px; height: 40px;"></div>
                                                    <div class="text-start">
                                                        <h6 class="mb-0">Mike T.</h6>
                                                        <small class="text-muted">{{ __('Contractor') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Call to Action -->
                            <div class="bg-primary text-white py-5">
                                <div class="container text-center">
                                    <h2 class="mb-4">{{ __('Ready to Start Your Project?') }}</h2>
                                    <p class="lead mb-4">{{ __('Get all the tools and equipment you need in one place') }}</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-5">
                                        <i class="bi bi-cart3 me-2"></i>{{ __('Shop Now') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
