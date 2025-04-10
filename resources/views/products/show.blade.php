@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Product Details</div>
                <div class="card-body">
                    @if($product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="img-fluid mb-4" alt="{{ $product->name }}">
                    @endif
                    <h2>{{ $product->name }}</h2>
                    <p class="text-muted">{{ $product->category->name }}</p>
                    <p class="h4">${{ number_format($product->price, 2) }}</p>
                    <p class="mt-4">{{ $product->description ?? 'No description available' }}</p>
                    
                    <form action="{{ route('cart.store', ['product' => $product->id]) }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
                    </form>
                    
                    <div class="mt-5">
                        <h4>Reviews</h4>
                        @if($product->reviews->count() > 0)
                            @foreach($product->reviews as $review)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5>{{ $review->user->name }}</h5>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="mb-0">{{ $review->comment }}</p>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        
                                        @auth
                                            @if(auth()->id() === $review->user_id)
                                                <div class="mt-2">
                                                    <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No reviews yet.</p>
                        @endif
                    </div>
                    
                    @auth
                        @if(auth()->user()->hasPurchasedProduct($product->id) && $product->transactions()->where('user_id', auth()->id())->where('status', 'completed')->exists() && !$hasReviewed)
                            <div class="mt-5">
                                @php
                                    $hasReviewed = auth()->user()->reviews()->where('product_id', $product->id)->exists();
                                @endphp
                                
                                @if($hasReviewed)
                                    <div class="alert alert-info">
                                        You have already reviewed this product.
                                    </div>
                                @elseif($product->reviews->count() === 0 || auth()->user()->reviews()->where('product_id', $product->id)->whereNotNull('deleted_at')->exists())
                                    <a href="{{ route('reviews.create', $product) }}" class="btn btn-primary">Write Review</a>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@endsection