@extends('layouts.master')

@section('title', 'Kuliner')

@section('content')

<div class="py-12">
    <h1 class="text-4xl font-bold text-brand-dark text-center mb-12">
        Kuliner Khas Manado
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <div class="bg-white rounded-lg shadow-lg transition-transform hover:-translate-y-2 hover:shadow-xl">
            <img src="https://asset.kompas.com/crops/GZP1r3C5qNg_J8bgVzQtupnPoBs=/81x22:892x563/1200x800/data/photo/2020/05/13/5ebbdec618a37.jpg" alt="Tinutuan (Bubur Manado)" class="w-full rounded-t-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-brand-dark mb-2">Tinutuan</h2>
                <p class="text-gray-700">
                    Dikenal sebagai Bubur Manado, sarapan sehat yang kaya sayuran
                    seperti labu kuning, kangkung, dan jagung.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg transition-transform hover:-translate-y-2 hover:shadow-xl">
            <img src="https://i.pinimg.com/1200x/4c/46/9f/4c469f84be68d717b05bad274b1c2428.jpg" alt="Ayam Rica-Rica" class="w-full rounded-t-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-brand-dark mb-2">Ayam Rica-Rica</h2>
                <p class="text-gray-700">
                    Hidangan ayam pedas dengan bumbu cabai, jahe, bawang, dan rempah lainnya.
                    Rasa pedasnya yang khas sangat menggugah selera.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg transition-transform hover:-translate-y-2 hover:shadow-xl">
            <img src="https://i.pinimg.com/1200x/33/51/58/335158de90ebb260f73ce8418ecd71c9.jpg" alt="Klapertart" class="w-full rounded-t-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-brand-dark mb-2">Klapertart</h2>
                <p class="text-gray-700">
                    Kue tart lembut dengan bahan dasar kelapa muda, susu, dan kayu manis.
                    Hidangan penutup khas Manado dengan pengaruh Belanda.
                </p>
            </div>
        </div>

    </div>
</div>

@endsection