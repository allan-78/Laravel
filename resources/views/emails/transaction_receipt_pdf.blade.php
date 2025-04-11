<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaction Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .receipt-info {
            margin-bottom: 20px;
        }
        .receipt-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
        .status {
            margin-top: 20px;
            padding: 10px;
            background-color: #f4f4f4;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Transaction Receipt</h1>
    </div>

    <div class="receipt-info">
        <p><strong>Order ID:</strong> {{ $transaction->id }}</p>
        <p><strong>Date:</strong> {{ $date }}</p>
        <p><strong>Customer:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>${{ number_format($product->price * $product->pivot->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Total: ${{ number_format($total, 2) }}</p>
    </div>

    <div class="status">
        <h2>Order Status: {{ ucfirst($status) }}</h2>
        @if($status === 'completed')
            <p>Thank you for your purchase! Your order has been completed successfully.</p>
        @elseif($status === 'failed')
            <p>We regret to inform you that your order has failed. Please contact our support team for assistance.</p>
        @elseif($status === 'refunded')
            <p>Your order has been refunded. The amount will be credited back to your payment method.</p>
        @endif
    </div>
</body>
</html>