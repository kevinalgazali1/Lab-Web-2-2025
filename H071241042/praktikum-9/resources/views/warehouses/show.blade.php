@extends('layouts.app')

@section('title', $warehouse->name)

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-warehouse me-2"></i>Warehouse: {{ $warehouse->name }}</h3>
                <div class="d-flex gap-1">
                    <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('warehouses.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3"><i class="fas fa-info-circle me-2"></i>Warehouse Information</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%"><i class="fas fa-hashtag me-1"></i>ID</th>
                                <td>{{ $warehouse->id }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-warehouse me-1"></i>Name</th>
                                <td>{{ $warehouse->name }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-map-marker-alt me-1"></i>Location</th>
                                <td>{{ $warehouse->location ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-plus me-1"></i>Created At</th>
                                <td>{{ $warehouse->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-check me-1"></i>Updated At</th>
                                <td>{{ $warehouse->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4 class="mb-3"><i class="fas fa-boxes me-2"></i>Products in this Warehouse</h4>
                        @if($warehouse->products->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th><i class="fas fa-cube me-1"></i>Product</th>
                                            <th><i class="fas fa-boxes me-1"></i>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($warehouse->products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    <i class="fas fa-box me-1"></i>{{ $product->pivot->quantity }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted"><i class="fas fa-info-circle me-1"></i>No products in this warehouse.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection