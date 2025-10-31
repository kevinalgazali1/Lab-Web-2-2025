@extends('layouts.master')

@section('title', 'Galeri')

@section('content')

<div class="py-24 text-center">
    <h1 class="text-5xl md:text-6xl font-bold text-brand-dark mb-6 animate-fade-in">
        Galeri Manado
    </h1>
    <p class="text-xl md:text-2xl max-w-3xl mx-auto text-gray-700 animate-fade-in-delay">
        Menangkap setiap sudut keindahan, dari surga bawah laut
        hingga denyut kehidupan kota.
    </p>
</div>
<div class="max-w-5xl mx-auto px-4 animate-fade-in">

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

        <div class="rounded-2xl shadow-lg overflow-hidden aspect-square">
            <img src="https://i.pinimg.com/1200x/9b/34/27/9b34279ca12b13b26b5e6c3d21fb8f1a.jpg"
                alt="Penyelam di Bunaken"
                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
        </div>

        <div class="rounded-2xl shadow-lg overflow-hidden aspect-square">
            <img src="https://i.pinimg.com/1200x/74/28/e9/7428e9a818e5f4c73bbe209d3e88cf14.jpg"
                alt="Monumen Yesus Memberkati dari samping"
                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
        </div>

        <div class="rounded-2xl shadow-lg overflow-hidden aspect-square">
            <img src="https://i.pinimg.com/1200x/4f/79/bc/4f79bcd46f028c8a9d263a6d3eca26ab.jpg"
                alt="Jembatan Soekarno di malam hari"
                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
        </div>

        <div class="rounded-2xl shadow-lg overflow-hidden aspect-square">
            <img src=https://shopee.co.id/inspirasi-shopee/wp-content/uploads/2021/12/ezgif.com-gif-maker-2021-12-03T163930.447.webp                alt="Rica"
                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
        </div>

        <div class="rounded-2xl shadow-lg overflow-hidden aspect-square">
            <img src="https://i.pinimg.com/1200x/ef/0f/4b/ef0f4b71a465d9cacfbdcee0df5006b5.jpg"
                alt="Klenteng Ban Hing Kiong"
                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
        </div>

        <div class="rounded-2xl shadow-lg overflow-hidden aspect-square">
            <img src="https://i.pinimg.com/1200x/e2/bc/7f/e2bc7f10153003b3be106dc933d08f59.jpg"
                alt="Bawah laut Bunaken"
                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
        </div>

    </div>
</div>
@endsection