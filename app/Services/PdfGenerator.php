<?php

namespace App\Services;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerator
{
    public function generateTransactionReceipt(Transaction $transaction): Pdf
    {
        $pdf = Pdf::loadView('emails.transaction_receipt_pdf', [
            'transaction' => $transaction,
            'user' => $transaction->user,
            'products' => $transaction->products,
            'status' => $transaction->status,
            'total' => $transaction->total,
            'date' => $transaction->created_at->format('Y-m-d H:i:s')
        ]);

        return $pdf;
    }
}