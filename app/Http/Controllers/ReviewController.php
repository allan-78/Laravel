<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{    
    public function index()
    {
        // Get all user's reviews (existing functionality)
        $reviews = Review::with('product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get unreviewed products with completed transactions
        $unreviewedProducts = \App\Models\Product::whereHas('transactions', function($query) {
                $query->where('status', 'completed')
                      ->where('user_id', auth()->id());
                })
                ->whereDoesntHave('reviews', function($query) {
                    $query->where('user_id', auth()->id());
                })
                ->with(['transactions', 'category'])
                ->get();
    
        return view('reviews.index', compact('reviews', 'unreviewedProducts'));
    }
    public function create(Product $product)
    {
        // Verify user has purchased this product before allowing review
        $hasPurchased = auth()->user()->transactions()->where('product_id', $product->id)->exists();
        
        if (!$hasPurchased) {
            return back()->with('error', 'You must purchase this product before reviewing it.');
        }
        
        return view('products.review', compact('product'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5',
            'product_id' => 'required|exists:products,id'
        ]);

        // Check if user has already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
            
        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product. You can edit your existing review instead.');
        }

        try {
            $review = new Review();
            $review->user_id = Auth::id();
            $review->product_id = $request->product_id;
            $review->comment = $request->comment;
            $review->rating = $request->rating;
            $review->save();

            return redirect()->route('products.show', $review->product_id)->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to save review: ' . $e->getMessage());
            return back()->with('error', 'Failed to submit review. Please try again.');
        }
    }

    public function edit(Review $review)
    {
        // Check if the user is authorized to edit this review
        if (Auth::id() !== $review->user_id) {
            return back()->with('error', 'You are not authorized to edit this review.');
        }
        
        $product = $review->product;
        return view('products.review-edit', compact('review', 'product'));
    }
    
    public function update(Request $request, Review $review)
    {
        // Check if the user is authorized to update this review
        if (Auth::id() !== $review->user_id) {
            return back()->with('error', 'You are not authorized to update this review.');
        }
        
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5'
        ]);

        try {
            $review->comment = $request->comment;
            $review->rating = $request->rating;
            $review->save();

            return redirect()->route('products.show', $review->product_id)->with('success', 'Review updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to update review: ' . $e->getMessage());
            return back()->with('error', 'Failed to update review. Please try again.');
        }
    }
    
    public function destroy(Review $review)
    {
        // Check if the user is authorized to delete this review
        if (Auth::id() !== $review->user_id) {
            return back()->with('error', 'You are not authorized to delete this review.');
        }
        
        $review->delete();
        return back()->with('success', 'Review deleted successfully!');
    }

    public function unreviewed()
    {
        $unreviewedProducts = \App\Models\Product::whereHas('transactions', function($query) {
                $query->where('status', 'completed')
                      ->where('user_id', auth()->id());
                })
                ->whereDoesntHave('reviews', function($query) {
                    $query->where('user_id', auth()->id());
                })
                ->with(['transactions', 'category'])
                ->get();
    
        return view('reviews.unreviewed', compact('unreviewedProducts'));
    }
}