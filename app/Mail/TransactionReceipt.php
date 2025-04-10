<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $pdf;

    public function __construct(Transaction $transaction, $pdf)
    {
        $this->transaction = $transaction;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Your Hardware Store Purchase Receipt')
            ->view('emails.transaction_receipt')
            ->attachData($this->pdf->output(), 'receipt.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}