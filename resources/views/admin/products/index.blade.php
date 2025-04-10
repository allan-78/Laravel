@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <span><i class="fas fa-tools me-2"></i>{{ __('EnM Hardware Products') }}</span>
                    <div>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-plus-circle me-1"></i> Add Product
                        </a>
                        <a href="{{ route('admin.products.import') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-file-excel me-1"></i> Import Excel
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <table id="products-table" class="table table-bordered table-striped">
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
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td class="fw-bold">{{ $product->name }}</td>
                                    <td>{{ Str::limit($product->description, 50) }}</td>
                                    <td class="text-primary fw-bold">${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        @if($product->images->count() > 0)
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                 class="rounded border" width="50" height="50" alt="Product Image">
                                            @if($product->images->count() > 1)
                                                <span class="badge bg-secondary">+{{ $product->images->count() - 1 }}</span>
                                            @endif
                                        @else
                                            <div class="text-center bg-light rounded p-1" style="width:50px; height:50px">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#products-table').DataTable();
        });
    </script>
@endsection

@endsection