@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>Manajemen Stok Produk per Gudang</h2>

    {{-- Filter Gudang --}}
    <form action="{{ route('stocks.index') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="warehouse_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Gudang Untuk Filter --</option>
                    @foreach ($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}" {{ $selectedWarehouse?->id == $warehouse->id ? 'selected' : '' }}>
                            {{ $warehouse->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <a href="{{ route('stocks.transfer.form') }}" class="btn btn-success">Transfer Stok</a>
            </div>
        </div>
    </form>

    @if($selectedWarehouse)
    <h3>Stok di Gudang: {{ $selectedWarehouse->name }}</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Total Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>Rp{{ number_format($product->price, 2, ',', '.') }}</td>
                {{-- Mengakses data quantity dari pivot table --}}
                <td>{{ $product->pivot->quantity }}</td> 
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada produk atau stok di gudang ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @else
        <div class="alert alert-info">Silahkan pilih gudang untuk menampilkan list stoknya.</div>
    @endif
</div>
@endsection