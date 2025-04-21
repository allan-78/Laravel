@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center py-3">
                    <i class="fas fa-tools me-2"></i>
                    <h5 class="mb-0 fw-bold">{{ __('Create New Hardware Product') }}</h5>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold text-dark mb-2">Product Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter product name" required>
                                </div>
                                @error('name')
                                    <div class="text-danger mt-2 small">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold text-dark mb-2">Product Description</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border">
                                        <i class="fas fa-align-left"></i>
                                    </span>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Detailed product description" required>{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <div class="text-danger mt-2 small">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="price" class="form-label fw-bold text-dark mb-2">Price (USD)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                                </div>
                                @error('price')
                                    <div class="text-danger mt-2 small">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-bold text-dark mb-2">Category</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border">
                                        <i class="fas fa-box"></i>
                                    </span>
                                    <select class="form-select" id="category" name="category">
                                        <option value="" selected disabled>Select Category</option>
                                        <option value="power_tools">Power Tools</option>
                                        <option value="hand_tools">Hand Tools</option>
                                        <option value="measuring_tools">Measuring Tools</option>
                                        <option value="safety_equipment">Safety Equipment</option>
                                        <option value="fasteners">Fasteners</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="stock" class="form-label fw-bold text-dark mb-2">Stock Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border">
                                        <i class="fas fa-boxes"></i>
                                    </span>
                                    <input type="number" class="form-control" id="stock" name="stock" placeholder="0" min="0">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="sku" class="form-label fw-bold text-dark mb-2">SKU</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border">
                                        <i class="fas fa-barcode"></i>
                                    </span>
                                    <input type="text" class="form-control" id="sku" name="sku" placeholder="ENM0001">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="images" class="form-label fw-bold text-dark mb-2">Product Images</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border">
                                        <i class="fas fa-images"></i>
                                    </span>
                                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                                </div>
                                <div class="text-muted small mt-2">
                                    <i class="fas fa-info-circle me-1"></i> You can upload multiple images. Accepted formats: JPG, PNG, GIF
                                </div>
                                @error('images.*')
                                    <div class="text-danger mt-2 small">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured">
                                    <label class="form-check-label fw-medium" for="featured">
                                        Feature this product on homepage
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-2">
                            <button type="button" class="btn btn-outline-secondary px-4" onclick="window.history.back();">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save me-2"></i> Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection