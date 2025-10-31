@extends('layouts.master')

@section('title', 'Destinasi Wisata')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <section class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Destinasi Wisata Unggulan Toraja</h1>
        <p class="text-xl text-gray-600">Temukan keindahan alam dan budaya Toraja yang memukau</p>
    </section>

    <!-- Destinations Grid -->
    <section class="grid md:grid-cols-3 gap-8 mb-12">
        <!-- Burake -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/destinations/burake.jpg" alt="Burake" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Burake</h3>
                <p class="text-gray-700 mb-4">
                    Bukit Burake menawarkan pemandangan spektakuler dengan patung Yesus yang membentang di puncaknya. 
                    Dari ketinggian, Anda dapat melihat pemandangan kota Makale dan perbukitan hijau yang memesona.
                </p>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">📍 Makale, Toraja Utara</span>
                </div>
            </div>
        </div>

        <!-- Dipomelo Pindan -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/destinations/dipomelo-pindan.jpg" alt="Dipomelo Pindan" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Dipomelo Pindan</h3>
                <p class="text-gray-700 mb-4">
                    Sebuah destinasi alam yang menakjubkan dengan formasi batuan unik dan pemandangan lembah hijau. 
                    Nama "Dipomelo Pindan" memiliki makna filosofis dalam budaya Toraja.
                </p>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">📍 Kecamatan Sangalla, Toraja</span>
                </div>
            </div>
        </div>

        <!-- Ke'te Kesu -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/destinations/kete-kesu.jpg" alt="Ke'te Kesu" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Ke'te Kesu</h3>
                <p class="text-gray-700 mb-4">
                    Desa adat Ke'te Kesu merupakan warisan budaya UNESCO dengan deretan rumah adat Tongkonan dan 
                    lumbung padi yang masih asli. Di sini Anda dapat melihat langsung ukiran tradisional Toraja.
                </p>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">📍 Desa Ke'te Kesu, Toraja</span>
                </div>
            </div>
        </div>

        <!-- Mentirotiku -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/destinations/mentirotiku.jpg" alt="Mentirotiku" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Mentirotiku</h3>
                <p class="text-gray-700 mb-4">
                    Air terjun Mentirotiku yang tersembunyi di balik hutan tropis Toraja menawarkan ketenangan dan 
                    keindahan alam yang masih perawan. Suara gemericik air menciptakan atmosfer yang menenangkan.
                </p>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">📍 Kecamatan Rindingallo, Toraja</span>
                </div>
            </div>
        </div>

        <!-- Tebing Romantiis -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105 ">
            <img src="/images/destinations/tebing-romantis.jpg" alt="Tebing Romantiis" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Tebing Romantiis</h3>
                <p class="text-gray-700 mb-4">
                    Tebing dengan pemandangan lembah hijau yang memukau, cocok untuk para pecinta alam dan fotografer. 
                    Dinamakan "Romantiis" karena pemandangan sunset-nya yang sangat indah.
                </p>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-600">📍 Kecamatan Bonggakaradeng, Toraja</span>
                </div>
            </div>
        </div>
    </section>


</div>
@endsection