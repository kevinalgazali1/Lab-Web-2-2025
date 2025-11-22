@extends('layouts.app')

@section('title', 'Detail Produk: ' . $product->name)

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">

    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $product->name }}</h1>
            <p class="text-lg text-gray-600">{{ $product->category->name ?? 'Tidak ada Kategori' }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('products.edit', $product) }}"
                class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-600 transition duration-300">
                <i class="fas fa-pencil-alt mr-1"></i> Edit
            </a>
            <a href="{{ route('products.index') }}"
                class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition duration-300">
                &laquo; Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="md:col-span-2 space-y-6">

            <div class="border-b border-gray-200 pb-4">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Info Utama</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Harga</span>
                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Berat</span>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->detail->weight ?? '-' }} kg</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Ukuran</span>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->detail->size ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Deskripsi</h2>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $product->detail->description ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        <div class="md:col-span-1">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Stok per Gudang</h2>
            <div class="bg-gray-50 p-4 rounded-lg border">
                <ul class="space-y-3">
                    @forelse($product->warehouses as $warehouse)
                    <li class="flex justify-between items-center">
                        <span class="text-gray-700">{{ $warehouse->name }}</span>
                        <span class="font-bold text-gray-900">{{ $warehouse->pivot->quantity }} Pcs</span>
                    </li>
                    @empty
                    <li class="text-gray-500">Produk ini tidak ada stok di gudang manapun.</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>

    <div class="mt-6 border-t border-gray-200 pt-4 text-sm text-gray-500">
        <p>Dibuat pada: {{ $product->created_at->format('d M Y, H:i') }}</p>
        <p>Diperbarui pada: {{ $product->updated_at->format('d M Y, H:i') }}</p>
    </div>

</div>
@endsection