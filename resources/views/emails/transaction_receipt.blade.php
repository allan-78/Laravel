@extends('layouts.email')

@section('content')
    <h1>Purchase Receipt</h1>
    <p>Thank you for your purchase at our Hardware Store!</p>
    
    <h2>Order Details</h2>
    <p><strong>Product:</strong> {{ $transaction->product->name }}</p>
    <p><strong>Quantity:</strong> {{ $transaction->quantity }}</p>
    <p><strong>Unit Price:</strong> ${{ number_format($transaction->product->price, 2) }}</p>
    <p><strong>Total Price:</strong> ${{ number_format($transaction->total_price, 2) }}</p>
    <p><strong>Date:</strong> {{ $transaction->created_at->format('M d, Y h:i A') }}</p>
    
    <p>If you have any questions about your order, please contact our support team.</p>
@endsection