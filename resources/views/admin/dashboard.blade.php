@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Sidebar styling will be in your layouts.admin template -->
    
    <div class="top-header mb-4">
        <h1 class="mb-0">EnM Hardware Dashboard</h1>
        <div class="date-range-picker">
            <div class="input-group">
                <input type="date" class="form-control" id="startDate">
                <span class="input-group-text">to</span>
                <input type="date" class="form-control" id="endDate">
                <button class="btn btn-primary" id="applyDateRange">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="mb-0">Total Sales</p>
                        <h3>$12,580</h3>
                        <small><i class="fas fa-arrow-up"></i> 15% vs last month</small>
                    </div>
                    <div>
                        <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="mb-0">Orders</p>
                        <h3>142</h3>
                        <small><i class="fas fa-arrow-up"></i> 8% vs last month</small>
                    </div>
                    <div>
                        <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="mb-0">Customers</p>
                        <h3>89</h3>
                        <small><i class="fas fa-arrow-up"></i> 12% vs last month</small>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="mb-0">Low Stock Items</p>
                        <h3>24</h3>
                        <small><i class="fas fa-exclamation-triangle"></i> Needs attention</small>
                    </div>
                    <div>
                        <i class="fas fa-boxes fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts (Preserving original functionality) -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Sales Analytics</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="date" class="form-control" id="startDate">
                            <span class="input-group-text">to</span>
                            <input type="date" class="form-control" id="endDate">
                            <button class="btn btn-primary" id="applyDateRange">Apply</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Product Sales Contribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="productContributionChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Content -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Top Selling Hardware Items</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>DeWalt Power Drill</td>
                                    <td><span class="badge bg-light text-dark">Power Tools</span></td>
                                    <td>$129.99</td>
                                    <td>42</td>
                                    <td>15</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Milwaukee Tool Set</td>
                                    <td><span class="badge bg-light text-dark">Hand Tools</span></td>
                                    <td>$199.99</td>
                                    <td>38</td>
                                    <td>7</td>
                                    <td><span class="badge bg-warning text-dark">Low Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Stanley Measuring Tape</td>
                                    <td><span class="badge bg-light text-dark">Measuring</span></td>
                                    <td>$24.99</td>
                                    <td>35</td>
                                    <td>28</td>
                                    <td><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Makita Circular Saw</td>
                                    <td><span class="badge bg-light text-dark">Power Tools</span></td>
                                    <td>$159.99</td>
                                    <td>31</td>
                                    <td>4</td>
                                    <td><span class="badge bg-danger">Critical Stock</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Orders</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <h6 class="mb-0">Order #38291</h6>
                                <small class="text-muted">John Smith - 2 items</small>
                            </div>
                            <span class="badge bg-info">Processing</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <h6 class="mb-0">Order #38290</h6>
                                <small class="text-muted">Sarah Johnson - 5 items</small>
                            </div>
                            <span class="badge bg-success">Shipped</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <h6 class="mb-0">Order #38289</h6>
                                <small class="text-muted">Robert Davis - 1 item</small>
                            </div>
                            <span class="badge bg-primary">Delivered</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <h6 class="mb-0">Order #38288</h6>
                                <small class="text-muted">Maria Garcia - 3 items</small>
                            </div>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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
                        beginAtZero: true
                    }
                }
            }
        });

        // Product Contribution Chart
        const productCtx = document.getElementById('productContributionChart').getContext('2d');
        const productChart = new Chart(productCtx, {
            type: 'pie',
            data: {
                labels: ['Product A', 'Product B', 'Product C', 'Product D'],
                datasets: [{
                    data: [30, 25, 20, 25],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        // Date range filter functionality
        document.getElementById('applyDateRange').addEventListener('click', function() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            // Here you would typically make an AJAX call to fetch filtered data
            // For now, we'll just log the dates
            console.log('Filtering from:', startDate, 'to', endDate);
            
            // In a real implementation, you would update the charts with new data
            // salesChart.data.labels = newLabels;
            // salesChart.data.datasets[0].data = newData;
            // salesChart.update();
        });
    });
</script>
@endpush

@endsection