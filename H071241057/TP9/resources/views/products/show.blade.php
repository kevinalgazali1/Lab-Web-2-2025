@extends('template.home')

@section('title', 'Detail Produk')

@section('content')
<div class="container">
    <h1>Detail Produk: {{ $product->name }}</h1>
    <div class="card">
        <div class="card-header">
            Detail Lengkap
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Data Utama --}}
                <div class="col-md-6">
                    <h3>Data Produk</h3>
                    <p><strong>Nama:</strong> {{ $product->name }}</p>
                    <p><strong>Kategori:</strong> {{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                </div>
                {{-- Data Detail --}}
                <div class="col-md-6">
                    <h3>Detail Tambahan</h3>
                    {{-- Asumsi relasi 1:1 $product->detail --}}
                    <p><strong>Deskripsi:</strong> {{ $product->detail->description ?? '-' }}</p>
                    <p><strong>Berat:</strong> {{ $product->detail->weight ?? '0' }} kg</p>
                    <p><strong>Ukuran:</strong> {{ $product->detail->size ?? '-' }}</p>
                </div>
            </div>

            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
