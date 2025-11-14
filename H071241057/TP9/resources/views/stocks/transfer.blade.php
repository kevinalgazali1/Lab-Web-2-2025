@extends('template.home')

@section('title', 'Transfer Stok')

@section('content')
<div class="container">
    <h1>Transfer Stok</h1>
    <p>Form dengan inputan memilih gudang, memilih produk, dan nilai stok yang masuk/keluar. </p>

    <div class="card">
        <div class="card-header">
            Form Transfer Stok
        </div>
        <div class="card-body">

            {{-- Menampilkan pesan sukses dari proses transfer --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Menampilkan pesan error validasi (misal stok tidak boleh minus)  --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    <strong>Gagal!</strong> {{ session('error') }}
                </div>
            @endif

            {{-- Menampilkan error validasi form --}}
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

            <form action="{{ route('stocks.processTransfer') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="warehouse_id" class="form-label">Gudang Tujuan</label>
                    <select class_select" id="warehouse_id" name="warehouse_id" required>
                        <option value="">-- Pilih Gudang --</option>
                        {{-- Asumsi $warehouses dikirim dari controller --}}
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="product_id" class="form-label">Produk</label>
                    <select class="form-select" id="product_id" name="product_id" required>
                        <option value="">-- Pilih Produk --</option>
                        {{-- Asumsi $products dikirim dari controller --}}
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Jumlah Transfer</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                    <div class="form-text">
                        Gunakan nilai positif (misal: <strong>10</strong>) untuk <strong>menambah</strong> stok. <br>
                        Gunakan nilai negatif (misal: <strong>-5</strong>) untuk <strong>mengurangi</strong> stok.
                    </div>
                </div>

                <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Proses Transfer</button>
            </form>
        </div>
    </div>
</div>
@endsection
