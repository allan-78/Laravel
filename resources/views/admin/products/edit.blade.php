@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center py-3">
                    <i class="fas fa-edit me-2"></i>
                    <h5 class="mb-0 fw-bold">{{ __('Edit Product') }}</h5>
                </div>

<<<<<<< HEAD
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

=======
                <div class="card-body p-4">
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-dark mb-2">Product Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            </div>
                            @error('name')
                                <div class="text-danger mt-2 small">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold text-dark mb-2">Description</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            </div>
                            @error('description')
                                <div class="text-danger mt-2 small">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label fw-bold text-dark mb-2">Price</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                            </div>
                            @error('price')
                                <div class="text-danger mt-2 small">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

<<<<<<< HEAD
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach(\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Existing Images</label>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @foreach($product->images as $image)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" width="100" height="100" class="img-thumbnail">
                                        <div class="form-check position-absolute top-0 end-0">
                                            <input class="form-check-input" type="checkbox" name="images_to_delete[]" value="{{ $image->id }}" id="image{{ $image->id }}">
                                        </div>
=======
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark mb-2">Existing Images</label>
                            <div class="d-flex flex-wrap gap-3 mb-3 p-3 bg-light rounded border">
                                @foreach($product->images as $image)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" width="100" height="100" class="img-thumbnail shadow-sm">
                                        <a href="#" class="position-absolute top-0 end-0 btn btn-sm btn-danger rounded-circle" 
                                           onclick="event.preventDefault(); document.getElementById('delete-image-{{ $image->id }}').submit();">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        <form id="delete-image-{{ $image->id }}" action="{{ route('admin.product-images.destroy', $image->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
>>>>>>> 8e9676835491269860c2e40603f115f0ca23d548
                                    </div>
                                @endforeach
                            </div>
                            @if($product->images->count() > 0)
                                <button type="submit" name="delete_images" value="1" class="btn btn-danger btn-sm mb-3" onclick="return confirm('Are you sure you want to delete selected images?')">
                                    Remove Selected Images
                                </button>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="images" class="form-label fw-bold text-dark mb-2">Add More Images</label>
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

                        <div class="d-flex justify-content-between mt-4 pt-2">
                            <button type="button" class="btn btn-outline-secondary px-4" onclick="window.history.back();">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save me-2"></i> Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection