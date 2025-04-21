@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Transactions</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                        <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                        <td>{{ $transaction->quantity }}</td>
                        <td>${{ number_format($transaction->total_price, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ 
                                $transaction->status === 'completed' ? 'success' : 
                                ($transaction->status === 'failed' ? 'danger' : 
                                ($transaction->status === 'refunded' ? 'warning' : 'info'))
                            }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <form id="statusForm-{{ $transaction->id }}" action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm" 
                                        onchange="event.preventDefault(); document.getElementById('statusForm-{{ $transaction->id }}').submit();">
                                    @foreach(['pending', 'completed', 'failed', 'refunded'] as $status)
                                        <option value="{{ $status }}" {{ $transaction->status === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection