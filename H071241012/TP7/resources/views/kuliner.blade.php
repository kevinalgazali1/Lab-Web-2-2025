@extends('layouts.master')

@section('title', 'Kuliner Khas')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <section class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Kuliner Autentik Toraja</h1>
        <p class="text-xl text-gray-600">Rasakan cita rasa tradisional yang telah turun-temurun</p>
    </section>

    <!-- Food Grid -->
    <section class="grid md:grid-cols-3 gap-8 mb-12">
        <!-- Pa'piong -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/foods/papiong.jpg" alt="Pa'piong" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Pa'piong</h3>
                <p class="text-gray-700 mb-4">
                    Masakan tradisional Toraja yang dimasak dalam bambu dengan campuran daging (babi atau ayam) dan 
                    rempah-rempah khas. Proses memasak dalam bambu memberikan aroma yang khas.
                </p>
            </div>
        </div>

        <!-- Pangrarang -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/foods/pangrarang.jpg" alt="Pangrarang" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Pangrarang</h3>
                <p class="text-gray-700 mb-4">
                    Daging sapi, kerbau, dan babi yang direbus dengan bumbu sederhana kemudian disajikan dengan sambal lu'at 
                    yang pedas. Biasanya disajikan dalam acara adat penting.
                </p>
            </div>
        </div>

        <!-- Tollo Pamarrasan -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/foods/tollo-pamarrasan.jpg" alt="Tollo Pamarrasan" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Tollo Pamarrasan</h3>
                <p class="text-gray-700 mb-4">
                    Ikan mas atau ikan sungai lainnya yang dimasak dengan bumbu pamarrasan (kemiri sangrai yang dihaluskan). 
                    Memiliki tekstur saus yang kental dan rasa gurih khas.
                </p>
            </div>
        </div>

        <!-- Utan Tutu -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/foods/utan-tutu.jpg" alt="Utan Tutu" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Utan Tutu</h3>
                <p class="text-gray-700 mb-4">
                    Sayuran daun ubi tumbuk yang dimasak dengan santan dan bumbu tradisional. Biasanya disajikan sebagai 
                    pendamping nasi dengan tekstur yang lembut.
                </p>
            </div>
        </div>

        <!-- Pokon -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
            <img src="/images/foods/pokon.jpg" alt="Pokon" class="w-full h-64 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-3">Pokon</h3>
                <p class="text-gray-700 mb-4">
                    Makanan tradisional yang terbuat dari beras ketan yang dibungkus dengan daun salak.
                </p>
            </div>
        </div>
    </section>
</div>
@endsection