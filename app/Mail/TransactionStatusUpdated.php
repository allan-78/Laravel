<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction;
use App\Services\PdfGenerator;

class TransactionStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $pdf;
    public $oldStatus;

    public function __construct(Transaction $transaction, $oldStatus)
    {
        $this->transaction = $transaction;
        $this->oldStatus = $oldStatus;
        $this->pdf = (new PdfGenerator())->generateTransactionReceipt($transaction)->output();
    }

    public function build()
    {
        return $this->subject('Your Transaction Status Update')
            ->view('emails.transaction_status_updated') // Make sure this view exists
            ->attachData($this->pdf, 'receipt.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}