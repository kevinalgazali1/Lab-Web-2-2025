@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Create New Product</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3"><i class="fas fa-info-circle me-2"></i>Basic Information</h4>
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-cube me-1"></i>Product Name *</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-tag me-1"></i>Price *</label>
                        <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-tags me-1"></i>Category</label>
                        <select class="form-select" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                <i class="fas fa-tag me-1"></i>{{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h4 class="mb-3"><i class="fas fa-clipboard-list me-2"></i>Product Details</h4>
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-file-alt me-1"></i>Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-weight-hanging me-1"></i>Weight (kg) *</label>
                        <input type="number" step="0.01" class="form-control" name="weight" value="{{ old('weight') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-ruler-combined me-1"></i>Size</label>
                        <input type="text" class="form-control" name="size" value="{{ old('size') }}">
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Create Product
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection