@extends('layouts.master')

@section('content')
<!-- Page Header -->
<section class="page-header py-32 text-center text-white bg-black/60 backdrop-blur-sm">
    <div class="container max-w-4xl mx-auto px-5">
        <h1 class="text-4xl font-bold mb-4">Kuliner Khas Jayapura</h1>
        <p class="text-xl opacity-90">Rasakan keautentikan cita rasa kuliner Papua yang menggugah selera</p>
    </div>
</section>

<!-- Culinary Grid -->
<section class="culinary py-16 bg-white/95 backdrop-blur-lg">
    <div class="container max-w-7xl mx-auto px-5">
        <div class="cards-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Kuliner 1 -->
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:translate-y-[-3px] hover:shadow-xl">
                <div class="card-image h-40 overflow-hidden">
                    <img src="/image/papeda-papua.jpg"
                         alt="Papeda"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="card-content p-4">
                    <h3 class="card-title text-lg font-semibold text-gray-800 mb-2">Papeda</h3>
                    <p class="card-description text-gray-600 text-sm leading-relaxed">
                        Papeda adalah makanan pokok khas Papua yang terbuat dari sagu. Teksturnya kental dan lengket seperti lem, biasanya disajikan bersama ikan kuah kuning
                        (biasanya ikan tongkol atau kakap) yang dimasak dengan kunyit, jeruk nipis, dan rempah-rempah khas Papua. Rasanya gurih, segar, dan menyehatkan.
                    </p>
                </div>
            </div>

            <!-- Kuliner 2 -->
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:translate-y-[-3px] hover:shadow-xl">
                <div class="card-image h-40 overflow-hidden">
                    <img src="/image/ulat-sagu.jpg"
                         alt="Ulat Sagu"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="card-content p-4">
                    <h3 class="card-title text-lg font-semibold text-gray-800 mb-2">Ulat Sagu</h3>
                    <p class="card-description text-gray-600 text-sm leading-relaxed">
                        Makanan ekstrem tapi bergizi tinggi ini adalah kuliner tradisional yang sangat populer di pedalaman Papua.
                        Ulat sagu hidup di dalam batang pohon sagu, dan bisa dimakan mentah atau dibakar.
                    </p>
                </div>
            </div>

            <!-- Kuliner 3 -->
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:translate-y-[-3px] hover:shadow-xl">
                <div class="card-image h-40 overflow-hidden">
                    <img src="/image/sagu-lempeng.jpg"
                         alt="Sagu Lempeng"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="card-content p-4">
                    <h3 class="card-title text-lg font-semibold text-gray-800 mb-2">Sagu Lempeng</h3>
                    <p class="card-description text-gray-600 text-sm leading-relaxed">
                        Makanan tradisional dari sagu yang dibakar hingga menjadi padat seperti roti kering. Rasanya agak hambar, jadi sering dimakan dengan kopi atau teh panas di pagi hari.
                        Sagu lempeng ini tahan lama dan bisa dibawa bepergian jauh, cocok untuk masyarakat pedalaman Papua.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection