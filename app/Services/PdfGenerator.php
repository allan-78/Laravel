<?php

namespace App\Services;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerator
{
    public function generateTransactionReceipt(Transaction $transaction): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('emails.transaction_receipt_pdf', [
            'transaction' => $transaction,
            'user' => $transaction->user,
            'products' => $transaction->product,
            'status' => $transaction->status,
            'total' => $transaction->total_price,
            'date' => $transaction->created_at->format('Y-m-d H:i:s')
        ]);
    }
}