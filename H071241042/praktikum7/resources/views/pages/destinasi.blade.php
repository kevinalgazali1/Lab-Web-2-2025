@extends('layouts.master')

@section('title', 'Destinasi Wisata')

@section('content')
<h2 class="text-3xl font-bold text-[#042440] mb-8 text-center">Destinasi Wisata Bromo</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <x-card 
        title="Penanjakan 1" 
        image="images/destinasi/penanjakan1.jpg"
        description="Spot terbaik untuk menyaksikan sunrise dengan pemandangan Gunung Bromo, Batok, dan Semeru. Ketinggian 2.770 mdpl."
    />

    <x-card 
        title="Kawah Bromo" 
        image="images/destinasi/kawahbromo.jpg"
        description="Kawah aktif dengan diameter ±800 meter. Dengarkan suara gemuruh dari dalam perut bumi dan saksikan kepulan asap belerang."
    />

    <x-card 
        title="Lautan Pasir" 
        image="images/destinasi/lautanpasir.webp"
        description="Hamparan pasir vulkanik seluas 10 km². Nikmati perjalanan dengan jeep atau kuda menuju kawah Bromo."
    />

    <x-card 
        title="Bukit Teletubbies" 
        image="images/destinasi/bukitteletubbies.jpg"
        description="Bukit hijau yang menyerupai pemandangan di serial Teletubbies. Pemandangan yang sangat instagramable."
    />

    <x-card 
        title="Pura Luhur Poten" 
        image="images/destinasi/puraluhurpoten.jpg"
        description="Pura suci Suku Tengger tempat upacara Kasada dilaksanakan setiap tahun. Arsitektur unik di lautan pasir."
    />

    <x-card 
        title="Ranu Pani & Ranu Kumbolo" 
        image="images/destinasi/ranurani_ranukumbolo.jpg"
        description="Danau cantik di kaki Gunung Semeru. Spot camping yang populer bagi pendaki menuju puncak Mahameru."
    />
</div>

<!-- Tips Section -->
<div class="mt-12 bg-[#b79393]/20 rounded-xl p-8 border border-[#b79393]">
    <h3 class="text-2xl font-bold text-[#042440] mb-4">Tips Berkunjung ke Bromo</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-[#042440]">
        <ul class="list-disc list-inside space-y-2">
            <li>Bawa jaket tebal karena suhu bisa mencapai 5°C</li>
            <li>Gunakan sepatu yang nyaman untuk berjalan</li>
            <li>Siapkan masker untuk menghindari debu vulkanik</li>
        </ul>
        <ul class="list-disc list-inside space-y-2">
            <li>Booking jeep dan penginapan sebelumnya</li>
            <li>Bangun pagi untuk tidak ketinggalan sunrise</li>
            <li>Hormati adat dan tradisi lokal</li>
        </ul>
    </div>
</div>
@endsection
