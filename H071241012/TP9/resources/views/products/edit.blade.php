@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Produk: {{ $product->name }}</h2>
    
    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Input Data Produk Utama --}}
        <div class="card mb-4">
            <div class="card-header">Data Produk Utama</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ $product->name ?? old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga (IDR)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" 
                           value="{{ $product->price ?? old('price') }}" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori Produk</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">-- Pilih Kategori (Opsional) --</option>
                        @foreach ($categories as $category)
                            {{-- Memilih kategori yang sedang terhubung --}}
                            <option value="{{ $category->id }}" 
                                {{ ($product->category_id == $category->id || old('category_id') == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        {{-- Input Data Detail Produk (Relasi 1:1) --}}
        <div class="card mb-4">
            <div class="card-header">Detail Produk</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Lengkap</label>
                    <textarea class="form-control" id="description" name="description">{{ $product->detail->description ?? old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Berat (kg)</label>
                    <input type="number" step="0.01" class="form-control" id="weight" name="weight" 
                           value="{{ $product->detail->weight ?? old('weight') }}" required>
                </div>
                <div class="mb-3">
                    <label for="size" class="form-label">Ukuran Produk</label>
                    <input type="text" class="form-control" id="size" name="size" 
                           value="{{ $product->detail->size ?? old('size') }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Perbarui Produk</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection