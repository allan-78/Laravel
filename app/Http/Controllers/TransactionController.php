<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionReceipt;
use App\Mail\OrderStatusUpdate;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $products = $request->input('products', []);
        
        if (!is_array($products) || empty($products)) {
            return back()->with('error', 'No products in cart');
        }
        
        foreach ($products as $productId => $quantity) {
            $product = Product::findOrFail($productId);
            
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->product_id = $productId;
            $transaction->quantity = $quantity;
            $transaction->total_price = $product->price * $quantity;
            $transaction->status = 'pending';
            if (!in_array($transaction->status, Transaction::STATUSES)) {
                return back()->with('error', 'Invalid transaction status');
            }
            $transaction->save();
        }

        // Send order confirmation email with PDF receipt
        $transaction = $user->transactions()->latest()->first();
        $pdf = Pdf::loadView('emails.receipt_pdf', [
            'transaction' => $transaction,
            'user' => $user,
            'items' => $user->transactions()->with('product')->latest()->get()
        ]);
        
        Mail::to($user->email)->send(
            new TransactionReceipt($user->transactions()->latest()->first(), $pdf)
        );

        // Clear cart after successful order
        $user->cartItems()->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!'
            ]);
        }

        return redirect()->route('home')->with('success', 'Order placed successfully!');

        // Clear the cart
        $user->cart()->delete();
        
        return redirect()->route('products.index')->with('success', 'Order placed successfully! You will receive a confirmation email shortly.');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', Transaction::STATUSES)
        ]);
        
        $transaction->update($validated);
        
        // Send status update email
        Mail::to($transaction->user->email)->send(
            new OrderStatusUpdate($transaction)
        );
        
        return back()->with('success', 'Status updated and notification sent!');
    }
}