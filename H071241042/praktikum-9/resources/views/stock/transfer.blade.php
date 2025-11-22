@extends('layouts.app')

@section('title', 'Transfer Stock')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Transfer Stock</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('stock.transfer') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-cube me-1"></i>Product *</label>
                        <select class="form-select" name="product_id" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (<i class="fas fa-coins me-1"></i>Rp {{ number_format($product->price, 0, ',', '.') }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-warehouse me-1"></i>Warehouse *</label>
                        <select class="form-select" name="warehouse_id" required>
                            <option value="">Select Warehouse</option>
                            @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }} (<i class="fas fa-map-marker-alt me-1"></i>{{ $warehouse->location }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-boxes me-1"></i>Quantity *</label>
                        <div class="d-flex align-items-center">
                            <span class="me-2"><i class="fas fa-plus-minus"></i></span>
                            <input type="number" class="form-control" name="quantity" 
                                placeholder="Positive to add, negative to remove" value="{{ old('quantity') }}" required>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Enter positive number to add stock, negative number to remove stock.
                            Example: +10 to add 10 units, -5 to remove 5 units.
                        </small>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-exchange-alt me-1"></i>Process Transfer
                        </button>
                        <a href="{{ route('stock.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection