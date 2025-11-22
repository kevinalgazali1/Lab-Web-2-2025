@extends('layouts.app')

@section('title', 'Edit Ikan: ' . $fish->name)

@section('content')
    <div class="p-6 rounded-lg shadow-md"
         style="background-color: rgba(31, 41, 55, 0.9);">

        <h1 class="text-2xl font-bold text-gray-100 mb-4">Edit Ikan: {{ $fish->name }}</h1>
        <p class="text-gray-300 mb-6">Perbarui detail ikan di bawah ini.</p>

        <form action="{{ route('fishes.update', $fish) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-200">Nama Ikan</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $fish->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-900 text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                           required>
                </div>

                <div>
                    <label for="rarity" class="block text-sm font-medium text-gray-200">Rarity</label>
                    <select id="rarity" name="rarity" 
                            class="mt-1 block w-full rounded-md border-gray-600 bg-gray-900 text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                            required>
                        <option value="">-- Pilih Rarity --</option>
                        @foreach($rarities as $rarity)
                            <option value="{{ $rarity }}" {{ old('rarity', $fish->rarity) == $rarity ? 'selected' : '' }}>
                                {{ $rarity }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="base_weight_min" class="block text-sm font-medium text-gray-200">Berat Minimum (kg)</label>
                        <input type="number" step="0.01" min="0.01" id="base_weight_min" name="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min) }}"
                               class="mt-1 block w-full rounded-md border-gray-600 bg-gray-900 text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               required>
                    </div>
                    <div>
                        <label for="base_weight_max" class="block text-sm font-medium text-gray-200">Berat Maksimum (kg)</label>
                        <input type="number" step="0.01" min="0.01" id="base_weight_max" name="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max) }}"
                               class="mt-1 block w-full rounded-md border-gray-600 bg-gray-900 text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sell_price_per_kg" class="block text-sm font-medium text-gray-200">Harga Jual (per kg)</label>
                        <input type="number" min="1" id="sell_price_per_kg" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}"
                               class="mt-1 block w-full rounded-md border-gray-600 bg-gray-900 text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               required>
                    </div>
                    <div>
                        <label for="catch_probability" class="block text-sm font-medium text-gray-200">Peluang Tangkap (%)</label>
                        <input type="number" step="0.01" min="0.01" max="100.00" id="catch_probability" name="catch_probability" value="{{ old('catch_probability', $fish->catch_probability) }}"
                               class="mt-1 block w-full rounded-md border-gray-600 bg-gray-900 text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               required>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-200">Deskripsi (Opsional)</label>
                    <textarea id="description" name="description" rows="4" 
                              class="mt-1 block w-full rounded-md border-gray-600 bg-gray-900 text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', $fish->description) }}</textarea>
                </div>

                <div class="flex items-center space-x-4 pt-4">
                    <button type="submit" 
                            class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('fishes.index') }}" 
                       class="inline-block px-6 py-2 bg-gray-600 text-gray-200 rounded-lg shadow hover:bg-gray-700 transition duration-300">
                        Batal
                    </a>
                </div>

            </div>
        </form>

    </div>
@endsection