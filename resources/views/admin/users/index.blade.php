@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2>User Management</h2>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            {!! $dataTable->table(['class' => 'table table-hover']) !!}
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title">Update User Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        .badge {
            font-size: 0.9em;
            padding: 0.5em 0.75em;
        }
        .bg-success { background-color: #198754 !important; }
        .bg-danger { background-color: #dc3545 !important; }
    </style>
@endpush

@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function() {
            // Add delete button column to DataTable
            window.LaravelDataTables['users-table'].on('draw', function() {
                $('.delete-user-btn').click(function(e) {
                    if (!confirm('Are you sure you want to delete this user?')) {
                        e.preventDefault();
                    }
                });
            });

            $('#statusModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const userId = button.data('user-id');
                const currentStatus = button.data('current-status');
                
                const form = $('#statusForm');
                form.attr('action', `/admin/users/${userId}/status`);
                form.find('select[name="is_active"]').val(currentStatus);
            });

            $('#statusForm').on('submit', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const url = form.attr('action');
                
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        $('#statusModal').modal('hide');
                        $('#users-table').DataTable().ajax.reload();
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endpush