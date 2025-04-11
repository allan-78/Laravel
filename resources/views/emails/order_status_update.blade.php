@component('mail::message')
# Order Status Update

Dear {{ $transaction->user->name }},

This email is to inform you that your order #{{ $transaction->id }} has been updated to: **{{ ucfirst($transaction->status) }}**

@if($transaction->status === 'completed')
Great news! Your order has been completed successfully. You can find the detailed receipt in the attached PDF.

@elseif($transaction->status === 'failed')
We regret to inform you that your order has been marked as failed. Please find the detailed information in the attached PDF. If you have any questions, please contact our support team.

@elseif($transaction->status === 'refunded')
Your order has been refunded. The refund will be processed to your original payment method. Please find the detailed receipt in the attached PDF.
@endif

Order Details:
- Order ID: {{ $transaction->id }}
- Order Date: {{ $transaction->created_at->format('Y-m-d') }}
- Total Amount: ${{ number_format($transaction->total, 2) }}

If you have any questions about this update, please don't hesitate to contact our support team.

Thank you for shopping with us!

Best regards,
The Hardware Store Team
@endcomponent