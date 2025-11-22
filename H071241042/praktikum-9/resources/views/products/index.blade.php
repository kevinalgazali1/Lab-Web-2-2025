@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-seedling me-2"></i>Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Add New Product
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0"><i class="fas fa-boxes me-2"></i>All Products</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-1"></i>No</th>
                    <th><i class="fas fa-cube me-1"></i>Name</th>
                    <th><i class="fas fa-tags me-1"></i>Category</th>
                    <th><i class="fas fa-tag me-1"></i>Price</th>
                    <th><i class="fas fa-weight-hanging me-1"></i>Weight</th>
                    <th><i class="fas fa-cogs me-1"></i>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
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
                    <td><i class="fas fa-coins me-1"></i>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td><i class="fas fa-weight me-1"></i>{{ $product->detail->weight ?? '0' }} kg</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Delete this product?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection