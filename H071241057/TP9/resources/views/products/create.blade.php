@extends('template.home')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="container">
    <h1>Tambah Produk Baru</h1>

    <div class="card">
        <div class="card-header">
            Form Tambah Produk
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    <strong>Gagal!</strong> {{ session('error') }}
                </div>
            @endif
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

            <form action="{{route('products.store')}}" method="POST">
                @csrf

                {{-- Bagian Data Produk --}}
                <h5 class="mt-3">Data Utama Produk (Tabel Products)</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Kategori (Opsional)</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">-- Pilih Kategori --</option>
                            {{-- Asumsi $categories dikirim dari controller --}}
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Harga Produk</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" step="0.1" min="0" required>
                </div>

                {{-- Bagian Data Detail Produk --}}
                <h5 class="mt-4">Data Detail Produk (Tabel ProductDetails)</h5>
                <hr>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Lengkap (Opsional)</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="weight" class="form-label">Berat Produk (kg)</label>
                        <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight') }}" step="0.01" min="0" placeholder="Contoh: 1.50" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="size" class="form-label">Ukuran (Opsional)</label>
                        <input type="text" class="form-control" id="size" name="size" value="{{ old('size') }}" placeholder="Contoh: 15 inch">
                    </div>
                </div>

                <a href="{{route('products.index')}}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
