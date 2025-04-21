@extends('layouts.admin')

@section('content')
<<<<<<< HEAD
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
=======
<div class="container-fluid py-4">
    <!-- Main Dashboard Content -->
    <div class="top-header d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 fw-bold text-dark">EnM Hardware Dashboard</h1>
        <div class="date-range-picker shadow-sm">
            <div class="input-group">
                <input type="date" class="form-control" id="startDate">
                <span class="input-group-text bg-light">to</span>
                <input type="date" class="form-control" id="endDate">
                <button class="btn btn-primary px-3" id="applyDateRange">
                    <i class="fas fa-filter me-2"></i> Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="mb-1 text-white-50">Total Sales</p>
                        <h2 class="fw-bold mb-1">$12,580</h2>
                        <small><i class="fas fa-arrow-up me-1"></i> 15% vs last month</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-dollar-sign fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="mb-1 text-white-50">Orders</p>
                        <h2 class="fw-bold mb-1">142</h2>
                        <small><i class="fas fa-arrow-up me-1"></i> 8% vs last month</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="mb-1 text-white-50">Customers</p>
                        <h2 class="fw-bold mb-1">89</h2>
                        <small><i class="fas fa-arrow-up me-1"></i> 12% vs last month</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="mb-1 text-black-50">Low Stock Items</p>
                        <h2 class="fw-bold mb-1">24</h2>
                        <small><i class="fas fa-exclamation-triangle me-1"></i> Needs attention</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-boxes fa-3x opacity-25"></i>
                    </div>
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Sales Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height: 300px;"></canvas>
=======
    <!-- Charts -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-3">Sales Analytics</h5>
                    <div class="chart-controls">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="date" class="form-control border" id="chartStartDate">
                            <span class="input-group-text bg-light">to</span>
                            <input type="date" class="form-control border" id="chartEndDate">
                            <button class="btn btn-primary btn-sm" id="applyChartDateRange">Apply</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <canvas id="salesChart" height="300"></canvas>
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                </div>
            </div>
        </div>
        
<<<<<<< HEAD
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Product Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="productChart" style="height: 300px;"></canvas>
=======
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold text-dark mb-3">Product Sales Contribution</h5>
                </div>
                <div class="card-body pt-2">
                    <canvas id="productContributionChart" height="300"></canvas>
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD

    <!-- Data Tables Section -->
    <div class="row">
        <!-- Top Selling Hardware -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Top Selling Hardware Items</h5>
=======
    
    <!-- Additional Content -->
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Top Selling Hardware Items</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary px-3">View All</a>
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
<<<<<<< HEAD
                        <table class="table" id="topProductsTable">
                            <thead>
=======
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Sold</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
<<<<<<< HEAD
                                <!-- Data will be loaded via JavaScript -->
=======
                                <tr>
                                    <td class="fw-medium">DeWalt Power Drill</td>
                                    <td><span class="badge bg-light text-dark">Power Tools</span></td>
                                    <td>$129.99</td>
                                    <td>42</td>
                                    <td>15</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Milwaukee Tool Set</td>
                                    <td><span class="badge bg-light text-dark">Hand Tools</span></td>
                                    <td>$199.99</td>
                                    <td>38</td>
                                    <td>7</td>
                                    <td><span class="badge bg-warning text-dark">Low Stock</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Stanley Measuring Tape</td>
                                    <td><span class="badge bg-light text-dark">Measuring</span></td>
                                    <td>$24.99</td>
                                    <td>35</td>
                                    <td>28</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Makita Circular Saw</td>
                                    <td><span class="badge bg-light text-dark">Power Tools</span></td>
                                    <td>$159.99</td>
                                    <td>31</td>
                                    <td>4</td>
                                    <td><span class="badge bg-danger">Critical Stock</span></td>
                                </tr>
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                    <h5 class="fw-bold text-dark mb-0">Recent Orders</h5>
                </div>
                <div class="card-body p-0">
<<<<<<< HEAD
                    <ul class="list-group list-group-flush" id="recentOrdersList">
                        <!-- Data will be loaded via JavaScript -->
=======
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0 border-bottom">
                            <div>
                                <h6 class="mb-1 fw-bold">Order #38291</h6>
                                <small class="text-muted">John Smith - 2 items</small>
                            </div>
                            <span class="badge bg-info rounded-pill px-3 py-2">Processing</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0 border-bottom">
                            <div>
                                <h6 class="mb-1 fw-bold">Order #38290</h6>
                                <small class="text-muted">Sarah Johnson - 5 items</small>
                            </div>
                            <span class="badge bg-success rounded-pill px-3 py-2">Shipped</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0 border-bottom">
                            <div>
                                <h6 class="mb-1 fw-bold">Order #38289</h6>
                                <small class="text-muted">Robert Davis - 1 item</small>
                            </div>
                            <span class="badge bg-primary rounded-pill px-3 py-2">Delivered</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-0">
                            <div>
                                <h6 class="mb-1 fw-bold">Order #38288</h6>
                                <small class="text-muted">Maria Garcia - 3 items</small>
                            </div>
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Pending</span>
                        </li>
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                    </ul>
                </div>
                <div class="card-footer bg-white border-top-0 text-center">
                    <a href="#" class="btn btn-sm btn-outline-secondary w-100">View All Orders</a>
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
<<<<<<< HEAD
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
=======
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales',
                    data: [1200, 1900, 3000, 2500, 2000, 3000],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                        }
                    }
                }
            }
<<<<<<< HEAD
        }
=======
        });

        // Product Contribution Chart
        const productCtx = document.getElementById('productContributionChart').getContext('2d');
        const productChart = new Chart(productCtx, {
            type: 'pie',
            data: {
                labels: ['Power Tools', 'Hand Tools', 'Fasteners', 'Plumbing'],
                datasets: [{
                    data: [30, 25, 20, 25],
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.7)',
                        'rgba(25, 135, 84, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderColor: [
                        'rgba(13, 110, 253, 1)',
                        'rgba(25, 135, 84, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Date range filter functionality
        document.getElementById('applyDateRange').addEventListener('click', function() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            // Here you would typically make an AJAX call to fetch filtered data
            console.log('Filtering from:', startDate, 'to', endDate);
        });
        
        // Chart date range filter
        document.getElementById('applyChartDateRange').addEventListener('click', function() {
            const startDate = document.getElementById('chartStartDate').value;
            const endDate = document.getElementById('chartEndDate').value;
            
            console.log('Chart filtering from:', startDate, 'to', endDate);
        });
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
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