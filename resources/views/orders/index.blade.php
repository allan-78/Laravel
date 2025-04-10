@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Orders</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>${{ number_format($order->total_price, 2) }}</td>
                    <td>
                        <span class="badge 
                            @if($order->status === 'completed') bg-success
                            @elseif($order->status === 'failed') bg-danger
                            @elseif($order->status === 'refunded') bg-secondary
                            @else bg-warning
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td>
                        @if($order->status === 'completed')
                            <a href="{{ route('products.review', $order->product_id) }}" class="btn btn-sm btn-success me-2">
                                Review
                            </a>
                        @endif
                        @if($order->status !== 'refunded')
                            <form action="{{ route('orders.destroy', $order) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to refund this order?')">
                                    Refund
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection