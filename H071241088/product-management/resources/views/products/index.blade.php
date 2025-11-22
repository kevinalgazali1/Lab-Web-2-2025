@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>Manajemen Produk</h2>
    {{-- Menampilkan list produk meliputi nama produk, kategori produk, dan harga --}}
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Kategori Produk</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                {{-- Menggunakan relasi category() untuk menampilkan nama kategori --}}
                <td>{{ $product->category->name ?? 'Tidak Ada Kategori' }}</td> 
                <td>Rp{{ number_format($product->price, 2, ',', '.') }}</td>
                <td>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">Show</a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection