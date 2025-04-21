@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2>Edit Review</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label>Rating</label>
                    <select name="rating" class="form-select">
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Comment</label>
                    <textarea name="comment" class="form-control" rows="5">{{ $review->comment }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Review</button>
            </form>
        </div>
    </div>
</div>
@endsection