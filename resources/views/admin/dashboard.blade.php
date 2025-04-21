@extends('layouts.admin')

@section('content')
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
                </div>
            </div>
        </div>
    </div>

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
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold text-dark mb-3">Product Sales Contribution</h5>
                </div>
                <div class="card-body pt-2">
                    <canvas id="productContributionChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Content -->
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Top Selling Hardware Items</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary px-3">View All</a>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                    <h5 class="fw-bold text-dark mb-0">Recent Orders</h5>
                </div>
                <div class="card-body p-0">
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
                    </ul>
                </div>
                <div class="card-footer bg-white border-top-0 text-center">
                    <a href="#" class="btn btn-sm btn-outline-secondary w-100">View All Orders</a>
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
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
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
    });
</script>
@endpush

@endsection