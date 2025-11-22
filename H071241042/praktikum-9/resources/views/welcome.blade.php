@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="text-center mb-5">
    <h1 class="mb-3">Product Management System</h1>
</div>

<div class="row mb-5">
    <div class="col-md-3">
        <div class="stats-card" style="background: var(--warna-biru);">
            <i class="fas fa-tags"></i>
            <span class="number">{{ $categoriesCount ?? 3 }}</span>
            <span class="label">CATEGORIES</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card" style="background: var(--warna-hijau);">
            <i class="fas fa-warehouse"></i>
            <span class="number">{{ $warehousesCount ?? 4 }}</span>
            <span class="label">WAREHOUSES</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card" style="background: var(--warna-oranye);">
            <i class="fas fa-box"></i>
            <span class="number">{{ $productsCount ?? 6 }}</span>
            <span class="label">PRODUCTS</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card" style="background: var(--warna-kuning); color: #8b6d2a;">
            <i class="fas fa-chart-bar"></i>
            <span class="number">{{ $totalStock ?? 6 }}</span>
            <span class="label">TOTAL STOCK</span>
        </div>
    </div>
</div>

<!-- Menu Cepat -->
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-tags fa-3x mb-3" style="color: var(--warna-hijau);"></i>
                <h5 class="card-title">Categories</h5>
                <p class="card-text text-muted">Kelola kategori dan klasifikasi produk</p>
                <a href="{{ route('categories.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-right me-2"></i>Manage Categories
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-warehouse fa-3x mb-3" style="color: var(--warna-hijau-gelap);"></i>
                <h5 class="card-title">Warehouses</h5>
                <p class="card-text text-muted">Manage storage locations</p>
                <a href="{{ route('warehouses.index') }}" class="btn btn-success mt-3">
                    <i class="fas fa-arrow-right me-2"></i>Manage Warehouses
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-box fa-3x mb-3" style="color: var(--warna-oranye);"></i>
                <h5 class="card-title">Products</h5>
                <p class="card-text text-muted">Kelola katalog produk</p>
                <a href="{{ route('products.index') }}" class="btn btn-warning mt-3">
                    <i class="fas fa-arrow-right me-2"></i>Manage Products
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="fas fa-chart-bar fa-3x mb-3" style="color: var(--warna-ungu);"></i>
                <h5 class="card-title">Stock Management</h5>
                <p class="card-text text-muted">Pantau dan kelola tingkat persediaan</p>
                <a href="{{ route('stock.index') }}" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-right me-2"></i>Manage Stock
                </a>
            </div>
        </div>
    </div>
</div>
@endsection