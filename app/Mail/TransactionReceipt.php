<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $transactions;
    public $pdf;
    public $user;

    public function __construct($transactions, $pdf, $user)
    {
        $this->transactions = $transactions;
        $this->pdf = $pdf;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your Purchase Receipt')
            ->view('emails.transaction_receipt', [
                'transactions' => $this->transactions,
                'user' => $this->user
            ])
            ->attachData($this->pdf->output(), 'receipt.pdf');
    }
}