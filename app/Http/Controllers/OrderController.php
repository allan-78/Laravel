<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Transaction::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->update(['status' => Transaction::STATUSES['refunded']]);
        
        return redirect()->route('orders.index')
            ->with('success', 'Order marked as refunded successfully');
    }
}