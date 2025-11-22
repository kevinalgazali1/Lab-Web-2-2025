@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-cube me-2"></i>Product: {{ $product->name }}</h3>
                <div class="d-flex gap-1">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3"><i class="fas fa-info-circle me-2"></i>Basic Information</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%"><i class="fas fa-hashtag me-1"></i>ID</th>
                                <td>{{ $product->id }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-cube me-1"></i>Name</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-tag me-1"></i>Price</th>
                                <td><i class="fas fa-coins me-1"></i>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-tags me-1"></i>Category</th>
                                <td>
                                    @if($product->category)
                                        <span class="badge badge-success">
                                            <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-times me-1"></i>No Category
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-plus me-1"></i>Created At</th>
                                <td>{{ $product->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-check me-1"></i>Updated At</th>
                                <td>{{ $product->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h4 class="mb-3"><i class="fas fa-clipboard-list me-2"></i>Product Details</h4>
                        @if($product->detail)
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%"><i class="fas fa-file-alt me-1"></i>Description</th>
                                <td>{{ $product->detail->description ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-weight-hanging me-1"></i>Weight</th>
                                <td><i class="fas fa-weight me-1"></i>{{ $product->detail->weight }} kg</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-ruler-combined me-1"></i>Size</th>
                                <td>{{ $product->detail->size ?? '-' }}</td>
                            </tr>
                        </table>
                        @else
                        <p class="text-muted"><i class="fas fa-info-circle me-1"></i>No product details available.</p>
                        @endif
                        
                        <h4 class="mt-4 mb-3"><i class="fas fa-warehouse me-2"></i>Stock in Warehouses</h4>
                        @if($product->warehouses->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-warehouse me-1"></i>Warehouse</th>
                                            <th><i class="fas fa-boxes me-1"></i>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product->warehouses as $warehouse)
                                        <tr>
                                            <td>{{ $warehouse->name }}</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    <i class="fas fa-box me-1"></i>{{ $warehouse->pivot->quantity }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted"><i class="fas fa-info-circle me-1"></i>No stock available in any warehouse.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection