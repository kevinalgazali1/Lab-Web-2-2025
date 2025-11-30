@extends('layouts.master')

@section('title', 'Galeri Foto')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <section class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Galeri Keindahan Toraja</h1>
        <p class="text-xl text-gray-600">Momen dan pesona Toraja dalam bidikan kamera</p>
    </section>

    <!-- Photo Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        @for($i = 1; $i <= 9; $i++)
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/gallery/galeri{{ $i }}.jpg" alt="Galeri {{ $i }}" class="w-full h-64 object-cover">
            <div class="p-4">
                <p class="text-gray-700 text-center font-medium">Pemandangan Toraja {{ $i }}</p>
            </div>
        </div>
        @endfor
    </section>
</div>
@endsection