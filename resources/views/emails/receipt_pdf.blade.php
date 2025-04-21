<h1>Order Receipt</h1>
<p>Customer: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transactions ?? [] as $transaction)
            @if($transaction?->product)
            <tr>
                <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                <td>{{ $transaction->quantity ?? 0 }}</td>
                <td>${{ number_format($transaction->product->price ?? 0, 2) }}</td>
                <td>${{ number_format($transaction->total_price ?? 0, 2) }}</td>
            </tr>
            @endif
        @empty
            <tr>
                <td colspan="4">No products in this order</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Total:</td>
            <td>${{ number_format($totalPrice, 2) }}</td>
        </tr>
    </tfoot>
</table>