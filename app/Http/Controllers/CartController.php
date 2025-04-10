<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to cart.
     */
    public function store(Request $request, Product $product)
    {
        $user = auth()->user();
        
        // Check if product already in cart
        $existingItem = $user->cartItems()->where('product_id', $product->id)->first();
        
        if ($existingItem) {
            // Update quantity if exists
            $existingItem->increment('quantity');
        } else {
            // Add new item to cart
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }
        
        return redirect()->route('cart.index')->with('status', 'Product added to cart!');
    }

    /**
     * Remove a product from cart.
     */
    public function destroy($item)
    {
        $user = auth()->user();
        $user->cartItems()->where('id', $item)->delete();
        
        return redirect()->route('cart.index')->with('status', 'Product removed from cart!');
    }
    
    /**
     * Process the checkout.
     */
    public function checkout()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('cart.checkout', compact('cartItems', 'total'));
    }
}