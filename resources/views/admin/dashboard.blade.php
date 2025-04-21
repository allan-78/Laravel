@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="top-header mb-4">
        <h1 class="mb-0">EnM Hardware Dashboard</h1>
        <div class="date-range-picker">
            <div class="input-group">
                <input type="date" class="form-control" id="startDate" value="{{ request('start_date', now()->subDays(30)->format('Y-m-d')) }}">
                <span class="input-group-text">to</span>
                <input type="date" class="form-control" id="endDate" value="{{ request('end_date', now()->format('Y-m-d')) }}">
                <button class="btn btn-primary" id="applyDateRange">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Sales Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Product Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="productChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Content -->
    <div class="row">
        <!-- Top Products Table -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Top Selling Hardware Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Sold</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts ?? [] as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ optional($product->category)->name ?? 'N/A' }}</td>
                                    <td>₱{{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->sold ?? 0 }}</td>
                                    <td>{{ $product->stock ?? 0 }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No products found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Orders -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Orders</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($recentOrders ?? collect() as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <h6 class="mb-0">Order #{{ $order->id }}</h6>
                                    <small class="text-muted">
                                        {{ optional($order->user)->name ?? 'N/A' }} - 
                                        {{ $order->quantity ?? 0 }} item{{ ($order->quantity ?? 0) > 1 ? 's' : '' }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $order->status === 'pending' ? 'warning text-dark' : 
                                    ($order->status === 'processing' ? 'info' : 
                                    ($order->status === 'shipped' ? 'success' : 
                                    ($order->status === 'delivered' ? 'primary' : 'secondary'))) }}">
                                    {{ ucfirst($order->status ?? 'unknown') }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-center">No recent orders</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Safely parse PHP data with defaults
    const salesData = @json($salesData ?? []);
    const productSales = @json($productSales ?? []);

    // Initialize charts only if elements exist
    const salesChartEl = document.getElementById('salesChart');
    const productChartEl = document.getElementById('productChart');

    if (salesChartEl) {
        const dates = Object.keys(salesData);
        const sales = Object.values(salesData);

        new Chart(salesChartEl, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Daily Sales',
                    data: sales,
                    backgroundColor: '#4e73df',
                    borderColor: '#4e73df',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    if (productChartEl && productSales.length > 0) {
        new Chart(productChartEl, {
            type: 'pie',
            data: {
                labels: productSales.map(item => item.name),
                datasets: [{
                    data: productSales.map(item => item.total_sales),
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return `${context.label}: ₱${context.raw.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Date Range Handler
    document.getElementById('applyDateRange')?.addEventListener('click', function() {
        const start = document.getElementById('startDate')?.value;
        const end = document.getElementById('endDate')?.value;
        
        if (start && end) {
            if (new Date(start) > new Date(end)) {
                alert('Start date cannot be after end date');
                return;
            }
            window.location.href = `?start_date=${start}&end_date=${end}`;
        } else {
            alert('Please select both start and end dates');
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .date-range-picker { margin-bottom: 1rem; }
    .card { box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
    .card-header { 
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    canvas { min-height: 300px; }
</style>
@endpush

@endsection