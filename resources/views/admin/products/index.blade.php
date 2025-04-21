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
                <i class="fas fa-file-import"></i> Import Products
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

            {!! $dataTable->table(['class' => 'table table-hover']) !!}
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

@endsection