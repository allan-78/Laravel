<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\DataTables\ReviewDataTable;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(ReviewDataTable $dataTable)
    {
        return $dataTable->render('admin.reviews.index');
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully');
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
    
        return view('admin.reviews.unreviewed', compact('unreviewedProducts'));
    }
}