<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Mail\TransactionReceipt;
use App\Services\PdfGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    protected $pdfGenerator;

    public function __construct(PdfGenerator $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function index()
    {
        return view('admin.orders.index');
    }

    public function data()
    {
        $transactions = Transaction::with(['user', 'product'])->select('transactions.*');

        return DataTables::of($transactions)
            ->addColumn('customer', function ($transaction) {
                return $transaction->user->name;
            })
            ->addColumn('product', function ($transaction) {
                return $transaction->product->name;
            })
            ->addColumn('quantity', function ($transaction) {
                return $transaction->quantity;
            })
            ->addColumn('date', function ($transaction) {
                return $transaction->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('total', function ($transaction) {
                return '$' . number_format($transaction->total_price, 2);
            })
            ->addColumn('actions', function ($transaction) {
                return '<button class="btn btn-sm btn-primary" onclick="openStatusModal(' . $transaction->id . ', \'' . $transaction->status . '\')">
                            Update Status
                        </button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function show(Transaction $transaction)
    {
        return view('admin.orders.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        try {
            $request->validate([
                'status' => 'required|in:' . implode(',', Transaction::STATUSES)
            ]);

            $transaction->status = $request->status;
            $transaction->save();

            // Generate PDF
            $pdf = $this->pdfGenerator->generateTransactionReceipt($transaction);

            // Send email with PDF attachment
            Mail::to($transaction->user->email)
                ->send(new TransactionReceipt($transaction, $pdf));

            return response()->json([
                'message' => 'Transaction status updated successfully',
                'status' => $transaction->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating transaction status: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.orders.index');
    }
}