@extends('layouts.app')

@section('title', 'Detail Ikan: ' . $fish->name)

@section('content')
    <div class="p-6 rounded-lg shadow-md"
         style="background-color: rgba(31, 41, 55, 0.9);">

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-100">Detail Ikan: {{ $fish->name }}</h1>
            <a href="{{ route('fishes.index') }}" 
               class="inline-block px-4 py-2 bg-gray-600 text-gray-200 rounded-lg shadow hover:bg-gray-700 transition duration-300">
                &laquo; Kembali ke Daftar
            </a>
        </div>

        <hr class="border-gray-600 my-6">

        <div class="space-y-4">
            <div class="flex items-center space-x-4">
                <h2 class="text-3xl font-semibold text-white">{{ $fish->name }}</h2>
                <span class="inline-block px-4 py-1 text-sm font-medium
                    @switch($fish->rarity)
                        @case('Common')
                            text-gray-300 border border-gray-500
                            @break
                        @case('Uncommon')
                            text-green-400 border border-green-500 rounded-lg
                            @break
                        @case('Rare')
                            text-blue-300 border border-blue-500 rounded-full shadow-md shadow-blue-500/30
                            @break
                        @case('Epic')
                            text-purple-300 ring-1 ring-purple-500 rounded-lg aura-epic
                            @break
                        @case('Legendary')
                            text-amber-300 ring-2 ring-amber-400/75 rounded-full aura-legendary
                            @break
                        @case('Mythic')
                            text-red-400 ring-2 ring-red-500/75 rounded-lg aura-mythic
                            @break
                        @case('Secret')
                            ring-2 ring-fuchsia-500/75 rounded-full aura-secret
                            @break
                        @default
                            text-gray-400 border border-gray-600 rounded-lg
                    @endswitch
                ">
                    {{ $fish->rarity }}
                </span>
            </div>

            <p class="text-lg text-gray-300">
                {!! nl2br(e($fish->description ?? 'Tidak ada deskripsi.')) !!}
            </p>

            <div class="pt-4">
                <h3 class="text-lg font-semibold text-gray-100 mb-2">Statistik Ikan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-700/50 p-4 rounded-lg">
                        <span class="text-sm font-medium text-gray-400">Berat</span>
                        <p class="text-xl font-semibold text-gray-100">{{ $fish->base_weight_min }} kg - {{ $fish->base_weight_max }} kg</p>
                    </div>
                    <div class="bg-gray-700/50 p-4 rounded-lg">
                        <span class="text-sm font-medium text-gray-400">Harga Jual (per kg)</span>
                        <p class="text-xl font-semibold text-gray-100">{{ $fish->sell_price_per_kg }} Coins</p>
                    </div>
                    <div class="bg-gray-700/50 p-4 rounded-lg">
                        <span class="text-sm font-medium text-gray-400">Peluang Tangkap</span>
                        <p class="text-xl font-semibold text-gray-100">{{ $fish->catch_probability }}%</p>
                    </div>
                    <div class="bg-gray-700/50 p-4 rounded-lg">
                        <span class="text-sm font-medium text-gray-400">ID Database</span>
                        <p class="text-xl font-semibold text-gray-100">#{{ $fish->id }}</p>
                    </div>
                </div>
            </div>

            <div class="text-sm text-gray-400 pt-4">
                <p>Data Dibuat: {{ $fish->created_at->format('d M Y, H:i') }}</p>
                <p>Data Diperbarui: {{ $fish->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <hr class="border-gray-600 my-6">

        <div class="flex items-center space-x-4">
            <a href="{{ route('fishes.edit', $fish) }}"
               class="inline-block px-6 py-2 bg-yellow-600 text-white rounded-lg shadow-md hover:bg-yellow-700 transition duration-300">
                Edit Ikan Ini
            </a>
            
            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="inline-block delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-block px-6 py-2 bg-red-600 text-white rounded-lg shadow-md hover:bg-red-700 transition duration-300">
                    Hapus Ikan Ini
                </button>
            </form>
        </div>

    </div>
@endsection

{{-- SCRIPT SWEETALERT UNTUK TOMBOL HAPUS DI HALAMAN INI --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForm = document.querySelector('.delete-form');
            
            if (deleteForm) {
                deleteForm.addEventListener('submit', function (event) {
                    event.preventDefault(); 
                    
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Data ikan ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        
                        background: '#1f2937', 
                        color: '#d1d5db', 
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#4b5563', 

                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteForm.submit();
                        }
                    });
                });
            }
        });
    </script>
@endpush