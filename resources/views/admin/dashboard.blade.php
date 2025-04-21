@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="top-header mb-4">
        <h1 class="mb-0">EnM Hardware Dashboard</h1>
        <div class="date-filter-container">
            <div class="row g-2">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="text" class="form-control date-range-picker" id="dashboardDateRange" 
                               placeholder="Select date range" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select quick-range-select">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last7days">Last 7 Days</option>
                        <option value="last30days">Last 30 Days</option>
                        <option value="thismonth">This Month</option>
                        <option value="lastmonth">Last Month</option>
                        <option value="thisyear">This Year</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" id="applyDateFilter">
                        <i class="fas fa-filter me-1"></i> Apply
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
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

    <!-- Data Tables Section -->
    <div class="row">
        <!-- Top Selling Hardware -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Top Selling Hardware Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="topProductsTable">
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
                                <!-- Data will be loaded via JavaScript -->
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
                    <ul class="list-group list-group-flush" id="recentOrdersList">
                        <!-- Data will be loaded via JavaScript -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<style>
.date-filter-container {
    background: #f8f9fc;
    padding: 1rem;
    border-radius: 0.35rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e3e6f0;
}
.card { box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
.card-header { 
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}
canvas { min-height: 300px; }
.loading {
    position: relative;
    opacity: 0.7;
    pointer-events: none;
}
.loading:after {
    content: " ";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.7) url("{{ asset('images/loading.gif') }}") no-repeat center center;
    z-index: 1000;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize date range picker
    $('#dashboardDateRange').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear'
        }
    });

    $('#dashboardDateRange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        loadDashboardData(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
    });

    $('#dashboardDateRange').on('cancel.daterangepicker', function() {
        $(this).val('');
    });

    // Quick range selection
    $('.quick-range-select').change(function() {
        const range = $(this).val();
        let startDate, endDate = moment().format('YYYY-MM-DD');
        
        switch(range) {
            case 'today':
                startDate = moment().format('YYYY-MM-DD');
                break;
            case 'yesterday':
                startDate = moment().subtract(1, 'days').format('YYYY-MM-DD');
                endDate = startDate;
                break;
            case 'last7days':
                startDate = moment().subtract(6, 'days').format('YYYY-MM-DD');
                break;
            case 'last30days':
                startDate = moment().subtract(29, 'days').format('YYYY-MM-DD');
                break;
            case 'thismonth':
                startDate = moment().startOf('month').format('YYYY-MM-DD');
                break;
            case 'lastmonth':
                startDate = moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD');
                endDate = moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD');
                break;
            case 'thisyear':
                startDate = moment().startOf('year').format('YYYY-MM-DD');
                break;
        }
        
        $('#dashboardDateRange').val(startDate + ' - ' + endDate);
        loadDashboardData(startDate, endDate);
    });

    // Apply button handler
    $('#applyDateFilter').click(function() {
        const dates = $('#dashboardDateRange').val().split(' - ');
        if(dates.length === 2) {
            loadDashboardData(dates[0], dates[1]);
        }
    });

    // Initialize charts
    let salesChart = new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: { labels: [], datasets: [] },
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

    let productChart = new Chart(document.getElementById('productChart'), {
        type: 'pie',
        data: { labels: [], datasets: [] },
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

    // Load dashboard data function
    function loadDashboardData(startDate, endDate) {
        // Show loading state
        $('.card-body').addClass('loading');
        
        // Fetch data via AJAX
        $.get('/admin/dashboard/data', {
            start_date: startDate,
            end_date: endDate
        }, function(data) {
            // Update charts
            salesChart.data.labels = data.sales.dates;
            salesChart.data.datasets = [{
                label: 'Daily Sales',
                data: data.sales.values,
                backgroundColor: '#4e73df',
                borderColor: '#4e73df',
                borderWidth: 1
            }];
            salesChart.update();

            productChart.data.labels = data.products.labels;
            productChart.data.datasets = [{
                data: data.products.values,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
            }];
            productChart.update();

            // Update top products table
            let topProductsHtml = '';
            data.topProducts.forEach(product => {
                topProductsHtml += `
                <tr>
                    <td>${product.name}</td>
                    <td>${product.category || 'N/A'}</td>
                    <td>₱${product.price.toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                    <td>${product.sold || 0}</td>
                    <td>${product.stock || 0}</td>
                </tr>`;
            });
            $('#topProductsTable tbody').html(topProductsHtml || '<tr><td colspan="5" class="text-center">No products found</td></tr>');

            // Update recent orders
            let recentOrdersHtml = '';
            data.recentOrders.forEach(order => {
                recentOrdersHtml += `
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <div>
                        <h6 class="mb-0">Order #${order.id}</h6>
                        <small class="text-muted">
                            ${order.user || 'N/A'} - 
                            ${order.quantity || 0} item${(order.quantity || 0) > 1 ? 's' : ''}
                        </small>
                    </div>
                    <span class="badge bg-${getStatusColor(order.status)}">
                        ${order.status ? order.status.charAt(0).toUpperCase() + order.status.slice(1) : 'Unknown'}
                    </span>
                </li>`;
            });
            $('#recentOrdersList').html(recentOrdersHtml || '<li class="list-group-item text-center">No recent orders</li>');

            // Remove loading state
            $('.card-body').removeClass('loading');
        });
    }

    function getStatusColor(status) {
        switch(status) {
            case 'pending': return 'warning text-dark';
            case 'processing': return 'info';
            case 'shipped': return 'success';
            case 'delivered': return 'primary';
            default: return 'secondary';
        }
    }

    // Load initial data
    loadDashboardData(
        moment().subtract(30, 'days').format('YYYY-MM-DD'),
        moment().format('YYYY-MM-DD')
    );
});
</script>
@endpush
@endsection