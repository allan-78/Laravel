@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-tools me-2"></i>
                    <h5 class="mb-0">{{ __('Create New Hardware Product') }}</h5>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold">Product Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter product name" required>
                                </div>
                                @error('name')
                                    <div class="text-danger mt-1 small">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">Product Description</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-align-left"></i>
                                    </span>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Detailed product description" required>{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <div class="text-danger mt-1 small">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-bold">Price (USD)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                                </div>
                                @error('price')
                                    <div class="text-danger mt-1 small">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-bold">Category</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-box"></i>
                                    </span>
                                    <select class="form-select" id="category_id" name="category_id">
                                        <option value="" selected disabled>Select Category</option>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="stock" class="form-label fw-bold">Stock Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-boxes"></i>
                                    </span>
                                    <input type="number" class="form-control" id="stock" name="stock" placeholder="0" min="0">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                
    }
  ]
}
```
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="images" class="form-label fw-bold">Product Images</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-images"></i>
                                    </span>
                                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                                </div>
                                <div class="text-muted small mt-1">
                                    <i class="fas fa-info-circle"></i> You can upload multiple images. Accepted formats: JPG, PNG, GIF
                                </div>
                                @error('images.*')
                                    <div class="text-danger mt-1 small">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured">
                                    <label class="form-check-label" for="featured">
                                        Feature this product on homepage
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back();">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save"></i> Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection