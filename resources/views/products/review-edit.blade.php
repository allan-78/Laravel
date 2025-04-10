@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Review for {{ $product->name }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reviews.update', $review) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="rating" class="col-md-4 col-form-label text-md-right">Rating</label>

                            <div class="col-md-6">
                                <select id="rating" class="form-control @error('rating') is-invalid @enderror" name="rating" required>
                                    <option value="">Select rating</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>

                                @error('rating')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">Review</label>

                            <div class="col-md-6">
                                <textarea id="comment" class="form-control @error('comment') is-invalid @enderror" name="comment" rows="5" required>{{ old('comment', $review->comment) }}</textarea>

                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Review
                                </button>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection