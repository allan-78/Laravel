<!DOCTYPE html>
<html>
<head>
    <title>Transaction Status Update</title>
</head>
<body>
    <h1>Transaction Status Update</h1>
    
    <p>Your transaction #{{ $transaction->id }} has been updated to: 
    <strong>{{ ucfirst($transaction->status) }}</strong></p>

    <p><strong>Product:</strong> {{ $transaction->product->name ?? 'N/A' }}</p>
    <p><strong>Quantity:</strong> {{ $transaction->quantity }}</p>
    <p><strong>Total:</strong> ${{ number_format($transaction->total_price, 2) }}</p>

    <p>
        <a href="{{ route('home') }}" style="background-color: #4e73df; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
            View Your Account
        </a>
    </p>

    <footer>
        <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </footer>
</body>
</html>