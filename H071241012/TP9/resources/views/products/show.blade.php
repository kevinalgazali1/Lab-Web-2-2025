@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>Detail Produk: {{ $product->name }}</h2>
    <div class="card mb-3">
        <div class="card-header">Data Produk Utama</div>
        <div class="card-body">
            <p><strong>Harga:</strong> Rp{{ number_format($product->price, 2, ',', '.') }}</p>
            <p><strong>Kategori:</strong> {{ $product->category->name ?? 'Tidak Ada' }}</p>
            <p><strong>Dibuat Pada:</strong> {{ $product->created_at }}</p>
        </div>
    </div>

    {{-- Data ProductDetail (Relasi 1:1) --}}
    <div class="card mb-3">
        <div class="card-header">Detail Spesifikasi</div>
        <div class="card-body">
            <p><strong>Deskripsi Lengkap:</strong> {{ $product->detail->description ?? '-' }}</p>
            <p><strong>Berat:</strong> {{ $product->detail->weight ?? '-' }} kg</p>
            <p><strong>Ukuran:</strong> {{ $product->detail->size ?? '-' }}</p>
        </div>
    </div>
    
    {{-- Data Stok (Relasi N:M) --}}
    <div class="card">
        <div class="card-header">Stok Produk di Gudang</div>
        <div class="card-body">
            @if($product->warehouses->isEmpty())
                <p>Produk ini belum memiliki stok di gudang manapun.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Gudang</th>
                            <th>Lokasi</th>
                            <th>Jumlah Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->warehouses as $warehouse)
                        <tr>
                            <td>{{ $warehouse->name }}</td>
                            <td>{{ $warehouse->location }}</td>
                            {{-- Mengakses data dari pivot table --}}
                            <td>{{ $warehouse->pivot->quantity }}</td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection