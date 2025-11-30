@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Form Transfer Stok</h2>
    
    <form action="{{ route('stocks.transfer.process') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="warehouse_id" class="form-label">Pilih Gudang Tujuan/Asal</label>
            <select class="form-select" id="warehouse_id" name="warehouse_id" required>
                @foreach ($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }} ({{ $warehouse->location }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Pilih Produk</label>
            <select class="form-select" id="product_id" name="product_id" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="stock_value" class="form-label">Nilai Stok Masuk/Keluar (+/-)</label>
            <input type="number" class="form-control" id="stock_value" name="stock_value" required>
            <div class="form-text">Contoh: +10 untuk menambah stok, -5 untuk mengurangi.</div>
        </div>

        <button type="submit" class="btn btn-success">Proses Transfer</button>
    </form>
</div>
@endsection