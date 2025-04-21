@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Import Products</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.products.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="file">Excel File</label>
                            <input type="file" class="form-control" name="file" id="file" required accept=".xlsx,.xls">
                            <small class="text-muted">Please upload an Excel file (.xlsx or .xls)</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-import"></i> Import Products
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection