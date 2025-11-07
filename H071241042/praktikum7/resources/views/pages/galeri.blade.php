@extends('layouts.master')

@section('title', 'Galeri Foto')

@section('content')
<h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Galeri Keindahan Bromo</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="overflow-hidden rounded-lg shadow-lg">
        <img src="images/galeri/sunrise.jpg" alt="Sunrise Penanjakan" class="w-full h-64 object-cover hover:scale-105 transition duration-300">
        <div class="p-4 bg-white">
            <p class="font-semibold text-gray-800">Sunrise di Penanjakan</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <img src="images/galeri/kawahbromo.jpg" alt="Kawah Bromo" class="w-full h-64 object-cover hover:scale-105 transition duration-300">
        <div class="p-4 bg-white">
            <p class="font-semibold text-gray-800">Kawah Gunung Bromo</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <img src="images/galeri/lautanpasir.webp" alt="Lautan Pasir" class="w-full h-64 object-cover hover:scale-105 transition duration-300">
        <div class="p-4 bg-white">
            <p class="font-semibold text-gray-800">Lautan Pasir Bromo</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <img src="images/galeri/bukitteletubbies.jpg" alt="Bukit Teletubbies" class="w-full h-64 object-cover hover:scale-105 transition duration-300">
        <div class="p-4 bg-white">
            <p class="font-semibold text-gray-800">Bukit Teletubbies</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <img src="images/galeri/sukutengger.jpg" alt="Suku Tengger" class="w-full h-64 object-cover hover:scale-105 transition duration-300">
        <div class="p-4 bg-white">
            <p class="font-semibold text-gray-800">Suku Tengger</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <img src="images/galeri/jeep.jpg" alt="Jeep Tour" class="w-full h-64 object-cover hover:scale-105 transition duration-300">
        <div class="p-4 bg-white">
            <p class="font-semibold text-gray-800">Jeep Tour Bromo</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <img src="images/galeri/ranurani_ranukumbolo.jpg" alt="Ranu Kumbolo" class="w-full h-64 object-cover hover:scale-105 transition duration-300">
        <div class="p-4 bg-white">
            <p class="font-semibold text-gray-800">Sunrise di Ranu Kumbolo</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <img src="images/galeri/puraluhurpoten.jpg" alt="Pura Poten" class="w-full h-64 object-cover hover:scale-105 transition duration-300">
        <div class="p-4 bg-white">
            <p class="font-semibold text-gray-800">Pura Luhur Poten</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-lg shadow-lg">
        <img src="images/galeri/malam.jpg" alt="Bintang di Bromo" class="w-full h-64 object-cover hover:scale-105 transition duration-300">
        <div class="p-4 bg-white">
            <p class="font-semibold text-gray-800">Langit Malam Bromo</p>
        </div>
    </div>
</div>

<div class="mt-8 text-center">
    <p class="text-gray-600">Foto-foto oleh para traveler dan fotografer profesional</p>
</div>
@endsection