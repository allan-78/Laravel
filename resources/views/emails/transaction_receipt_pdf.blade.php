<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $transaction->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>EnM Hardware Store</h2>
        <h3>Receipt #{{ $transaction->id }}</h3>
        <p>Date: {{ $date }}</p>
    </div>

    <div class="details">
        <p><strong>Customer:</strong> {{ $user->name ?? 'Guest Customer' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($status ?? 'pending') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $products->name ?? 'Unknown Product' }}</td>
                <td>${{ number_format($products->price ?? 0, 2) }}</td>
                <td>{{ $transaction->quantity ?? 1 }}</td>
                <td>${{ number_format($total ?? 0, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        <p>Total: ${{ number_format($total, 2) }}</p>
    </div>
</body>
</html>