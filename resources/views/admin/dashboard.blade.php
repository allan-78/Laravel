@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
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