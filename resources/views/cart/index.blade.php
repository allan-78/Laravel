@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Shopping Cart</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($cartItems) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>${{ number_format($item->product->price, 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width: 70px;">
                                            </form>
                                        </td>
                                        <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Total: ${{ number_format($total, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="text-end">
                            <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
                        </div>
                    @else
                        <p>Your cart is empty.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection