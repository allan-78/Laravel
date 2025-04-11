@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <div class="top-header mb-4">
        <h1 class="mb-0">Orders Management</h1>
    </div>

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <table class="table table-hover" id="orders-table">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="statusUpdateForm">
                    <input type="hidden" id="orderId" name="orderId">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateStatus()">Update Status</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.orders.data") }}',
                order: [[0, 'desc']],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'customer', name: 'user.name' },
                    { 
                        data: 'total', 
                        name: 'total',
                        render: function(data) {
                            return '$' + parseFloat(data).toFixed(2);
                        }
                    },
                    { 
                        data: 'status', 
                        name: 'status',
                        render: function(data) {
                            const statusClasses = {
                                'pending': 'bg-warning',
                                'processing': 'bg-info',
                                'completed': 'bg-success',
                                'cancelled': 'bg-danger',
                                'failed': 'bg-danger',
                                'refunded': 'bg-secondary'
                            };
                            return `<span class="badge ${statusClasses[data.toLowerCase()]}">${data}</span>`;
                        }
                    },
                    { 
                        data: 'created_at', 
                        name: 'created_at',
                        render: function(data) {
                            return new Date(data).toLocaleDateString();
                        }
                    },
                    { 
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {
                            return `<button class="btn btn-sm btn-primary" onclick="openStatusModal(${row.id}, '${row.status}')">
                                <i class="fas fa-edit me-1"></i>Update Status
                            </button>`;
                        }
                    }
                ]
            });
        });


    function openStatusModal(orderId, currentStatus) {
        $('#orderId').val(orderId);
        $('#status').val(currentStatus);
        $('#statusModal').modal('show');
    }

    function updateStatus() {
        const orderId = $('#orderId').val();
        const status = $('#status').val();

        $.ajax({
            url: `/admin/orders/${orderId}/status`,
            type: 'PUT',
            data: {
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#statusModal').modal('hide');
                $('#orders-table').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert('Error updating status. Please try again.');
            }
        });
    }
    </script>
@endpush