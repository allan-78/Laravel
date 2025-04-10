<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaction Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .total { font-weight: bold; text-align: right; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Transaction Receipt</h1>
        <p>Order #{{ $transaction->id }}</p>
        <p>Date: {{ $transaction->created_at->format('m/d/Y') }}</p>
    </div>

    <div class="details">
        <h3>Customer Information</h3>
        <p>{{ $user->name }}</p>
        <p>{{ $user->email }}</p>
    </div>

    <h3>Order Details</h3>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total: ${{ number_format($transaction->total, 2) }}</p>
    </div>

    <div class="footer">
        <p>Thank you for your purchase!</p>
    </div>
</body>
</html>