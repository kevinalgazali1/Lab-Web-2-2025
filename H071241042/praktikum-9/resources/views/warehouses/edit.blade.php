@extends('layouts.app')

@section('title', 'Edit Warehouse')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Warehouse: {{ $warehouse->name }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-warehouse me-1"></i>Warehouse Name *</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $warehouse->name) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Location</label>
                        <textarea class="form-control" name="location" rows="3">{{ old('location', $warehouse->location) }}</textarea>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Warehouse
                        </button>
                        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection