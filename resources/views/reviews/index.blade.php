@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Reviews</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($reviews->count() > 0)
        <div class="row">
            @foreach($reviews as $review)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $review->product->name }}</h5>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="card-body">
                            <p>{{ $review->comment }}</p>
                            <small class="text-muted">Posted {{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('products.show', $review->product_id) }}" class="btn btn-sm btn-primary">View Product</a>
                            <div>
                                <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-secondary me-2">Edit</a>
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <p>You haven't written any reviews yet.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">Browse Products</a>
        </div>
    @endif

    <!-- ADDED SECTION FOR UNREVIEWED PRODUCTS -->
    <div class="mt-5">
        <h2>Products Awaiting Your Review</h2>
        @if(isset($unreviewedProducts) && $unreviewedProducts->count() > 0)
            <div class="row">
                @foreach($unreviewedProducts as $product)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ $product->name }}</h5>
                        </div>
                        <div class="card-body">
                            <p>Purchased on {{ $product->transactions->first()->created_at->format('M d, Y') }}</p>
                            <a href="{{ route('reviews.create', $product) }}" class="btn btn-primary">
                                Write Review
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                No products awaiting your review.
            </div>
        @endif
    </div>
</div>
@endsection