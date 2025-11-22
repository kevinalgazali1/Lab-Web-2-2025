@extends('layouts.master')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<div class="text-center mb-16 py-12 bg-gradient-to-r from-[#4E499E] via-[#B793C9] to-[#D26B9D] rounded-2xl text-white shadow-lg">
    <h2 class="text-5xl font-bold mb-6">Selamat Datang di Dunia Bromo</h2>
    <p class="text-xl max-w-3xl mx-auto leading-relaxed text-[#2d3640]">
        Jelajahi keajaiban alam Gunung Bromo yang memukau. Dari sunrise di Penanjakan hingga 
        lautan pasir yang luas, rasakan pengalaman tak terlupakan di salah satu destinasi 
        terindah Indonesia.
    </p>
    <div class="mt-8">
        <a href="/destinasi" 
           class="bg-white text-[#4E499E] font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-[#A2BEDC] hover:text-[#042440] transition">
           Jelajahi Sekarang
        </a>
    </div>
</div>

<!-- Highlights -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
    <x-card 
        title="Sunrise Spektakuler" 
        image="images/sunrise.jpg"
        description="Saksikan matahari terbit dari Penanjakan dengan pemandangan Gunung Bromo, Batok, dan Semeru yang memukau."
    >
    </x-card>

    <x-card 
        title="Lautan Pasir" 
        image="images/lautanpasir.webp"
        description="Jelajahi lautan pasir yang luas dengan jeep atau menunggang kuda menuju kawah Bromo."
    >
    </x-card>

    <x-card 
        title="Budaya Tengger" 
        image="images/sukutengger.jpg"
        description="Kenali kehidupan dan tradisi unik Suku Tengger yang tinggal di sekitar Bromo."
    >
    </x-card>
</div>

<!-- Quick Info -->
<div class="bg-[#A2BEDC]/40 rounded-xl p-8 shadow-md">
    <h3 class="text-2xl font-bold text-center mb-6 text-[#4E499E]">Mengapa Harus Ke Bromo?</h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
        <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-lg transition">
            <div class="text-3xl font-bold text-[#4E499E]">2.329</div>
            <div class="text-[#042440]">mdpl</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-lg transition">
            <div class="text-3xl font-bold text-[#4E499E]">4:30</div>
            <div class="text-[#042440]">Waktu Terbaik Sunrise</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-lg transition">
            <div class="text-3xl font-bold text-[#4E499E]">800+</div>
            <div class="text-[#042440]">meter diameter kawah</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-lg transition">
            <div class="text-3xl font-bold text-[#4E499E]">100%</div>
            <div class="text-[#042440]">Pengalaman Tak Terlupakan</div>
        </div>
    </div>
</div>
@endsection
