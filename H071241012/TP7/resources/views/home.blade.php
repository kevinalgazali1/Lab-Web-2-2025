@extends('layouts.master')

@section('title', 'Home')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Hero Section -->
    <section class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Selamat Datang di Toraja</h1>
    </section>

    <!-- Introduction -->
    <section class="mb-12">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Mengenal Toraja</h2>
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <p class="text-gray-700 text-lg mb-4">
                        "Toraja, sebuah negeri mistis di dataran tinggi Sulawesi Selatan, menyimpan kekayaan budaya yang tak ternilai. 
                        Dikenal dengan rumah adat Tongkonan yang megah, upacara Rambu Solo yang penuh makna, dan pemandangan alam yang memukau, 
                        Toraja adalah destinasi yang menawarkan pengalaman spiritual dan visual yang tak terlupakan. Setiap ukiran, setiap ritual, 
                        dan setiap panorama di sini bercerita tentang warisan leluhur yang tetap lestari hingga kini."
                    </p>
                </div>
                <div class="flex justify-center">
                    <img src="/images/thumbnails/tongkonan-toraja.jpg" alt="Tongkonan Toraja" class="rounded-lg shadow-md w-full max-w-md h-64 object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Links -->
    <section class="grid md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/thumbnails/destinasi.jpg" alt="Destinasi Wisata" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Destinasi Wisata</h3>
                <p class="text-gray-600 mb-4">Temukan tempat-tempat menakjubkan yang wajib dikunjungi di Toraja.</p>
                <a href="/destinasi" class="block w-full text-center border border-red-900 text-red-900 hover:bg-red-900 hover:text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Lihat Destinasi
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/thumbnails/kuliner.jpg" alt="Kuliner Khas" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Kuliner Khas</h3>
                <p class="text-gray-600 mb-4">Rasakan kelezatan makanan tradisional Toraja yang autentik.</p>
                <a href="/kuliner" class="block w-full text-center border border-red-900 text-red-900 hover:bg-red-900 hover:text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Eksplor Kuliner
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/thumbnails/galeri.jpg" alt="Galeri Foto" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Galeri Foto</h3>
                <p class="text-gray-600 mb-4">Lihat keindahan Toraja melalui koleksi foto-foto menakjubkan.</p>
                <a href="/galeri" class="block w-full text-center border border-red-900 text-red-900 hover:bg-red-900 hover:text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    Lihat Galeri
                </a>
            </div>
        </div>
    </section>
</div>
@endsection