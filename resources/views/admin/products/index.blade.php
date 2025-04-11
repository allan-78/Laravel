@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="top-header mb-4">
        <h1 class="mb-0">Products Management</h1>
        <div class="d-flex">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus-circle me-1"></i> Add Product
            </a>
            <a href="{{ route('admin.products.import') }}" class="btn btn-success">
                <i class="fas fa-file-excel me-1"></i> Import Excel
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <table class="table table-hover" id="products-table">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

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
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.products.data") }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { 
                        data: 'price', 
                        name: 'price',
                        render: function(data) {
                            return '$' + parseFloat(data).toFixed(2);
                        }
                    },
                    { data: 'images', name: 'images' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush

@endsection