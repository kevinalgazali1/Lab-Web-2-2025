@extends('layouts.app')

@section('title', 'Transfer Stok')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Transfer Stok (Masuk/Keluar)</h1>

    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf

        <div class="space-y-4">

            <div>
                <label for="warehouse_id" class="block text-sm font-medium text-gray-700">Pilih Gudang</label>
                <select id="warehouse_id" name="warehouse_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                    <option value="">-- Pilih Gudang --</option>
                    @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                        {{ $warehouse->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                <select id="product_id" name="product_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah Transfer</label>
                <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Contoh: 10 (masuk) atau -5 (keluar)"
                    required>
                <p class="mt-1 text-xs text-gray-500">Gunakan angka positif untuk stok masuk atau angka negatif untuk stok keluar. Tidak boleh 0.</p>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('stocks.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition duration-300">
                    Batal
                </a>
                <button type="submit"
                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    Proses Transfer
                </button>
            </div>

        </div>
    </form>

</div>
@endsection