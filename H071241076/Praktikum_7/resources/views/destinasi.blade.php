@extends('layouts.master')

@section('title', 'Destinasi')

@section('content')

<div class="relative h-96 flex items-center justify-center overflow-hidden rounded-2xl mb-12">

    <div class="absolute w-full h-full bg-cover bg-center bg-fixed z-0"
        style="background-image: url('https://i.pinimg.com/1200x/82/88/9c/82889c4e4b27d60c72f8f665da735be7.jpg');">
    </div>

    <div class="absolute inset-0 bg-black opacity-40 z-10"></div>

    <div class="relative z-20 text-center text-white px-4">
        <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in">
            Destinasi Unggulan
        </h1>
        <p class="text-xl md:text-2xl max-w-3xl mx-auto animate-fade-in-delay">
            Jelajahi keajaiban alam dan ikon budaya Manado.
        </p>
    </div>
</div>
<div class="py-16 bg-white rounded-2xl shadow-lg overflow-hidden mb-12">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <div>
            <img src="{{ asset('images/bunaken.jpg') }}" alt="Taman Nasional Bunaken"
                class="w-full h-full object-cover rounded-2xl shadow-lg transition-transform duration-300 hover:scale-105">
        </div>

        <div class="animate-fade-in">
            <h2 class="text-4xl font-bold text-brand-dark mb-4">
                Taman Nasional Bunaken
            </h2>
            <p class="text-lg text-gray-700 leading-relaxed">
                Surga bagi para penyelam dan pecinta *snorkeling*. Taman laut ini adalah rumah bagi
                salah satu keanekaragaman hayati laut tertinggi di dunia. Nikmati keindahan
                terumbu karang vertikal yang menakjubkan dan bertemu dengan ribuan spesies ikan
                serta penyu-penyu yang ramah.
            </p>
            <a href="https://id.wikipedia.org/wiki/Taman_Nasional_Bunaken" target="_blank"
                class="inline-block mt-6 bg-brand-dark text-white px-6 py-3 rounded-full font-semibold 
                            hover:bg-opacity-90 transition duration-300 transform hover:scale-105">
                Pelajari Lebih Lanjut
            </a>
        </div>

    </div>
</div>
<div class="py-16 mb-12">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <div class="animate-fade-in">
            <h2 class="text-4xl font-bold text-brand-dark mb-4">
                Monumen Yesus Memberkati
            </h2>
            <p class="text-lg text-gray-700 leading-relaxed">
                Ikon kebanggaan kota Manado yang menjulang tinggi. Dengan posisi
                menghadap kota, monumen ini seakan memberkati dan melindungi warga.
                Selain sebagai tempat ziarah, lokasi ini menawarkan pemandangan
                spektakuler kota Manado dan laut di baliknya.
            </p>
            <a href="https://id.wikipedia.org/wiki/Patung_Yesus_Memberkati" target="_blank"
                class="inline-block mt-6 bg-brand-dark text-white px-6 py-3 rounded-full font-semibold 
                            hover:bg-opacity-90 transition duration-300 transform hover:scale-105">
                Pelajari Lebih Lanjut
            </a>
        </div>

        <div>
            <img src="{{ asset('images/patung-yesus.jpg') }}" alt="Monumen Yesus Memberkati"
                class="w-full h-full object-cover rounded-2xl shadow-lg transition-transform duration-300 hover:scale-105">
        </div>

    </div>
</div>
<div class="py-16 bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <div>
            <img src="{{ asset('images/pantai-malalayang.jpg') }}" alt="Pantai Malalayang"
                class="w-full h-full object-cover rounded-2xl shadow-lg transition-transform duration-300 hover:scale-105">
        </div>

        <div class="animate-fade-in">
            <h2 class="text-4xl font-bold text-brand-dark mb-4">
                Pantai Malalayang
            </h2>
            <p class="text-lg text-gray-700 leading-relaxed">
                Tempat favorit warga lokal untuk bersantai dan menikmati matahari terbenam yang memukau.
                Pantai ini terkenal dengan jajaran warung yang menyajikan
                kuliner khas, terutama pisang goreng dengan sambal roa yang nikmat,
                sambil memandang Pulau Manado Tua di kejauhan.
            </p>
            <a href="https://regional.kompas.com/read/2023/08/10/222107278/pantai-malalayang-di-manado-daya-tarik-harga-tiket-dan-rute" target="_blank"
                class="inline-block mt-6 bg-brand-dark text-white px-6 py-3 rounded-full font-semibold 
                            hover:bg-opacity-90 transition duration-300 transform hover:scale-105">
                Pelajari Lebih Lanjut
            </a>
        </div>

    </div>
</div>
@endsection