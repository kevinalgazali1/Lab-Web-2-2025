@extends('layouts.app')

@section('title', 'Stock Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-warehouse me-2"></i>Stock Management</h2>
    <a href="{{ route('stock.transfer.form') }}" class="btn btn-primary">
        <i class="fas fa-exchange-alt me-1"></i> Transfer Stock
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Stock Overview</h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-4">
            <label class="form-label"><i class="fas fa-filter me-1"></i>Filter by Warehouse</label>
            <select class="form-select" onchange="window.location.href = this.value">
                <option value="{{ route('stock.index') }}">
                    <i class="fas fa-layer-group me-1"></i>All Warehouses
                </option>
                @foreach($warehouses as $warehouse)
                <option value="{{ route('stock.index', ['warehouse_id' => $warehouse->id]) }}" 
                    {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                    <i class="fas fa-warehouse me-1"></i>{{ $warehouse->name }}
                </option>
                @endforeach
            </select>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th><i class="fas fa-cube me-1"></i>Product</th>
                    <th><i class="fas fa-tags me-1"></i>Category</th>
                    <th><i class="fas fa-tag me-1"></i>Price</th>
                    @if(!request('warehouse_id'))
                        @foreach($warehouses as $warehouse)
                        <th><i class="fas fa-warehouse me-1"></i>{{ $warehouse->name }}</th>
                        @endforeach
                    @else
                        <th><i class="fas fa-boxes me-1"></i>Stock</th>
                    @endif
                    <th><i class="fas fa-chart-pie me-1"></i>Total Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}. {{ $product->name }}</td>
                    <td>
                        @if($product->category)
                            {{ $product->category->name }}
                        @else
                            <i class="fas fa-times me-1"></i>No Category
                        @endif
                    </td>
                    <td><i class="fas fa-coins me-1"></i>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    
                    @if(!request('warehouse_id'))
                        @foreach($warehouses as $warehouse)
                        <td>
                            @php
                                $stock = $product->warehouses->firstWhere('id', $warehouse->id);
                                $quantity = $stock ? $stock->pivot->quantity : 0;
                            @endphp
                            <span class="badge badge-{{ $quantity > 0 ? 'success' : 'secondary' }}">
                                <i class="fas fa-{{ $quantity > 0 ? 'check' : 'times' }} me-1"></i>{{ $quantity }}
                            </span>
                        </td>
                        @endforeach
                    @else
                        <td>
                            @php
                                $stock = $product->warehouses->firstWhere('id', request('warehouse_id'));
                                $quantity = $stock ? $stock->pivot->quantity : 0;
                            @endphp
                            <span class="badge badge-{{ $quantity > 0 ? 'success' : 'secondary' }}">
                                <i class="fas fa-{{ $quantity > 0 ? 'check' : 'times' }} me-1"></i>{{ $quantity }}
                            </span>
                        </td>
                    @endif
                    
                    <td>
                        @php
                            $totalStock = $product->warehouses->sum('pivot.quantity');
                        @endphp
                        <span class="badge badge-{{ $totalStock > 0 ? 'primary' : 'secondary' }}">
                            <i class="fas fa-boxes me-1"></i>{{ $totalStock }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection