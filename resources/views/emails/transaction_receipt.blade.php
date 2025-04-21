@extends('layouts.email')

@section('content')
    <h1>Purchase Receipt</h1>
    <p>Thank you for your purchase, {{ $user->name }}!</p>
    <p>Email: {{ $user->email }}</p>
    
    <h2>Order Details</h2>
    @foreach($transactions as $transaction)
        @if($transaction->product)
        <div>
            <h3>{{ $transaction->product->name }}</h3>
            <p>Quantity: {{ $transaction->quantity }}</p>
            <p>Price: ${{ number_format($transaction->product->price, 2) }}</p>
            <p>Total: ${{ number_format($transaction->total_price, 2) }}</p>
        </div>
        @endif
    @endforeach
    
    <p><strong>Order Date:</strong> {{ now()->format('M d, Y h:i A') }}</p>
    <p>If you have any questions, please contact our support team.</p>
@endsection