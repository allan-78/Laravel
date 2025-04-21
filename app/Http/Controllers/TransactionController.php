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
        
        $transactions = [];
        $totalPrice = 0;
        
        foreach ($products as $productId => $quantity) {
            $product = Product::findOrFail($productId);
            if ($product->stock < $quantity) {
                return back()->with('error', 'Insufficient stock for ' . $product->name);
            }
            
            $product->decrement('stock', $quantity);
            
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->product_id = $productId;
            $transaction->quantity = $quantity;
            $transaction->total_price = $product->price * $quantity;
            $transaction->status = 'pending';
            $transaction->save();
            
            // Verify the transaction was created and has a product
            if (!$transaction || !$transaction->product) {
                return back()->with('error', 'Error processing product: ' . $product->name);
            }
            
            $transactions[] = $transaction;
            $totalPrice += $transaction->total_price;
        }
    
        // Send order confirmation email with PDF receipt
        $pdf = Pdf::loadView('emails.receipt_pdf', [
            'transactions' => $transactions,
            'user' => $user,
            'totalPrice' => $totalPrice
        ]);
        
        Mail::to($user->email)->send(
            new TransactionReceipt($transactions, $pdf, $user)
        );
    
        // Clear cart after successful order
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