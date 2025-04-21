<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cart()->with('product.images')->get();
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id
            ],
            ['quantity' => $request->quantity]
        );

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('cart.index')->with('status', 'Product removed from cart!');
    }
    
    public function checkout()
    {
        $cartItems = auth()->user()->cart()->with('product.images')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.checkout', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:10']);
        
        auth()->user()->cart()
            ->where('product_id', $product->id)
            ->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Quantity updated!');
    }
}