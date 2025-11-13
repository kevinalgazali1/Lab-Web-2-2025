@extends('layouts.app')

@section('title', 'Edit Produk: ' . $product->name)

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk: {{ $product->name }}</h1>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

            <div class="md:col-span-2">
                <h2 class="text-lg font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Info Produk Utama</h2>
            </div>

            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" id="name" name="name"
                    value="{{ old('name', $product->name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori (Opsional)</label>
                <select id="category_id" name="category_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Tidak ada Kategori --</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{-- Logika untuk 'selected' --}}
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                <input type="number" step="0.01" min="0" id="price" name="price"
                    value="{{ old('price', $product->price) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <div class="md:col-span-2 mt-6">
                <h2 class="text-lg font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">Info Detail Produk</h2>
            </div>

            <div>
                <label for="weight" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                <input type="number" step="0.01" min="0" id="weight" name="weight"
                    value="{{ old('weight', $product->detail->weight ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <label for="size" class="block text-sm font-medium text-gray-700">Ukuran (Opsional)</label>
                <input type="text" id="size" name="size"
                    value="{{ old('size', $product->detail->size ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Lengkap (Opsional)</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $product->detail->description ?? '') }}</textarea>
            </div>

            <div class="md:col-span-2 flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('products.index') }}"
                    class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition duration-300">
                    Batal
                </a>
                <button type="submit"
                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </form>

</div>
@endsection