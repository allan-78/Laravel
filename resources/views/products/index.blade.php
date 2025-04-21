@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Filter Section -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body p-3">
            <form id="filter-form" class="row g-2" method="GET" action="{{ route('products.index') }}">
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="min_price" class="form-control" placeholder="Min Price"
                           value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_price" class="form-control" placeholder="Max Price"
                           value="{{ request('max_price') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search products..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm product-card">
                @if($product->images->count() > 0)
                    <img src="{{ asset('storage/'.$product->images->first()->image_path) }}"
                         class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/300" class="card-img-top" style="height: 180px; object-fit: cover;" alt="No image">
                @endif
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title mb-1">{{ $product->name }}</h6>
                    <p class="text-muted small mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    <h6 class="text-primary mb-3">${{ number_format($product->price, 2) }}</h6>
                    <div class="mt-auto">
                        <div class="card-footer bg-white">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <input type="number" name="quantity" value="1" min="1" class="form-control">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-secondary w-100">
                            Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">No products found.</div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->appends(request()->query())->onEachSide(1)->links() }}
    </div>
</div>

@push('styles')
<style>
    .product-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .product-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    }
</style>
@endpush
@endsection
