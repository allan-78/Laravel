@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Order Summary</h5>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>${{ number_format($item->product->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>${{ number_format($total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <form action="{{ route('transactions.store') }}" method="POST" class="mt-4" id="checkoutForm">
    @csrf
    
    @foreach($cartItems as $item)
        <input type="hidden" name="products[{{ $item->product_id }}]" value="{{ $item->quantity }}">
    @endforeach
    
    <button type="submit" class="btn btn-primary">Place Order</button>
</form>

<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Successful!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your order has been placed successfully!</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>


</div>
@endsection