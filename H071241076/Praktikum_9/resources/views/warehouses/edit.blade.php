@extends('layouts.app')

@section('title', 'Edit Gudang')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Gudang: {{ $warehouse->name }}</h1>

    <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
        @csrf
        @method('PUT') <div class="space-y-4">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Gudang</label>
                <input type="text" id="name" name="name"
                    value="{{ old('name', $warehouse->name) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
            </div>

            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">Lokasi (Opsional)</label>
                <textarea id="location" name="location" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('location', $warehouse->location) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('warehouses.index') }}"
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