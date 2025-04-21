@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0">
                <i class="fas fa-star-half-alt"></i> Products Awaiting Your Review
            </h3>
        </div>

        <div class="card-body">
            @if($unreviewedProducts->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-check-circle"></i> You have reviewed all your purchased products.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Purchase Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unreviewedProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>
                                    {{ optional($product->transactions->first())->created_at->format('M d, Y') ?? 'N/A' }}
                                </td>
                                <td>
                                    <a href="{{ route('reviews.create', $product) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-pen"></i> Write Review
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection