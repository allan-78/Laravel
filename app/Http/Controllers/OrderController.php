<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->transactions()
            ->with(['product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function refund(Transaction $transaction)
    {
        // Ensure user can only refund their own orders
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $transaction->update(['status' => 'refunded']);
        
        return redirect()->route('orders.index')
            ->with('success', 'Order has been marked as refunded');
    }
}