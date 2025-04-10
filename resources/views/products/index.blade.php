@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Filters</div>
                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="mb-3">
                            <label for="price_range" class="form-label">Price Range</label>
                            <select class="form-select" name="price_range" id="price_range">
                                <option value="">All Prices</option>
                                <option value="0-50">$0 - $50</option>
                                <option value="50-100">$50 - $100</option>
                                <option value="100-200">$100 - $200</option>
                                <option value="200+">$200+</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category" id="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                @if($products->count() > 0)
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                            @if($product->images->count() > 0)
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Placeholder">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">
                                    <span class="text-muted">{{ $product->category->name }}</span><br>
                                    <strong>${{ number_format($product->price, 2) }}</strong>
                                </p>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('cart.store', ['product' => $product->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-info">No products found matching your criteria.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection