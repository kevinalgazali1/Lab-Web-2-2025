@extends('template.home')

@section('title', 'Edit Produk')

@section('content')
<div class="container">
    <h1>Edit Produk: {{ $product->name }}</h1>

    <div class="card">
        <div class="card-header">
            Form Edit Produk
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong> Terdapat masalah dengan inputan Anda:<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Asumsi: $product->detail adalah relasi 1:1 --}}
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Bagian Data Produk --}}
                <h5 class="mt-3">Data Utama Produk (Tabel Products)</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Kategori (Opsional)</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga Produk</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                </div>

                {{-- Bagian Data Detail Produk --}}
                <h5 class="mt-4">Data Detail Produk (Tabel ProductDetails)</h5>
                <hr>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Lengkap (Opsional)</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->detail->description ?? '') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="weight" class="form-label">Berat Produk (kg)</label>
                        <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight', $product->detail->weight ?? '') }}" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="size" class="form-label">Ukuran (Opsional)</label>
                        <input type="text" class="form-control" id="size" name="size" value="{{ old('size', $product->detail->size ?? '') }}">
                    </div>
                </div>

                <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
