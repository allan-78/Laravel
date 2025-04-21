@extends('layouts.admin')

@section('content')
<<<<<<< HEAD
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
=======
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white py-3">
                    <span class="fw-bold fs-5"><i class="fas fa-tools me-2"></i>{{ __('EnM Hardware Products') }}</span>
                    <div>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-light">
                            <i class="fas fa-plus-circle me-2"></i> Add Product
                        </a>
                        <a href="{{ route('admin.products.import') }}" class="btn btn-success ms-2">
                            <i class="fas fa-file-excel me-2"></i> Import Excel
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-check-circle me-2 fs-5"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="products-table" class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold">ID</th>
                                    <th class="fw-bold">Name</th>
                                    <th class="fw-bold">Description</th>
                                    <th class="fw-bold">Price</th>
                                    <th class="fw-bold">Images</th>
                                    <th class="fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td class="fw-bold">{{ $product->name }}</td>
                                        <td>{{ Str::limit($product->description, 50) }}</td>
                                        <td class="text-primary fw-bold">${{ number_format($product->price, 2) }}</td>
                                        <td>
                                            @if($product->images->count() > 0)
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                         class="rounded shadow-sm border" width="60" height="60" alt="Product Image">
                                                    @if($product->images->count() > 1)
                                                        <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-secondary">
                                                            +{{ $product->images->count() - 1 }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-center bg-light rounded-3 p-2 border" style="width:60px; height:60px">
                                                    <i class="fas fa-image text-muted mt-2 fs-5"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <i class="fas fa-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                </div>
            @endif

            {!! $dataTable->table(['class' => 'table table-hover']) !!}
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<<<<<<< HEAD
@endpush

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
=======
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#products-table').DataTable({
                responsive: true,
                order: [[0, 'desc']],
                language: {
                    search: '<i class="fas fa-search"></i> _INPUT_',
                    searchPlaceholder: 'Search products...'
                },
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ]
            });
        });
    </script>
@endsection
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548

@endsection