<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use App\Services\PdfGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionStatusUpdated;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'product'])->latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded'
        ]);

        $oldStatus = $transaction->status;
        $transaction->update(['status' => $validated['status']]);
        
        // Send email for any status change
        try {
            Mail::to($transaction->user->email)
                ->send(new TransactionStatusUpdated($transaction, $oldStatus));
        } catch (\Exception $e) {
            Log::error('Failed to send transaction email: ' . $e->getMessage());
        }

        return back()->with('success', 'Transaction status updated!');
    }
}