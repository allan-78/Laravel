<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Mail\TransactionReceipt;
use App\Services\PdfGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $transactions = Transaction::with(['user:id,name', 'product:id,name'])->select('transactions.*');

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
                return number_format($transaction->total_price, 2);
            })
            ->addColumn('status', function ($transaction) {
                $statusClasses = [
                    'pending' => 'bg-warning text-dark',
                    'processing' => 'bg-info',
                    'completed' => 'bg-success',
                    'failed' => 'bg-danger',
                    'refunded' => 'bg-secondary'
                ];
                return '<span class="badge ' . $statusClasses[$transaction->status] . '">' . ucfirst($transaction->status) . '</span>';
            })
            ->addColumn('action', function ($transaction) {
                return '<button class="btn btn-sm btn-primary" onclick="openStatusModal(' . $transaction->id . ', \'' . $transaction->status . '\')">
                            <i class="fas fa-edit me-1"></i>Update Status
                        </button>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        try {
            $request->validate([
                'status' => 'required|in:' . implode(',', Transaction::STATUSES)
            ]);

            $oldStatus = $transaction->status;
            $transaction->status = $request->status;
            $transaction->save();

            // Only send email if status changed to completed
            if ($oldStatus !== 'completed' && $request->status === 'completed') {
                // Generate PDF using the service
                $pdf = $this->pdfGenerator->generateTransactionReceipt($transaction);
                
                // Send email with PDF attachment
                Mail::to($transaction->user->email)->send(new TransactionReceipt($transaction, $pdf));
            }

            return response()->json([
                'message' => 'Order status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating status. Please try again.'
            ], 422);
        }
        
    }
}