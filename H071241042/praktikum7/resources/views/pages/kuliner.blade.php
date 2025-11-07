@extends('layouts.master')

@section('title', 'Kuliner Khas')

@section('content')
<h2 class="text-3xl font-bold text-[#042440] mb-8 text-center">Kuliner Khas Bromo & Sekitarnya</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <x-card 
        title="Sate Kelinci" 
        image="images/kuliner/satekelinci.jpg"
        description="Sate daging kelinci khas Bromo yang empuk dan gurih. Biasanya disajikan dengan bumbu kacang atau kecap."
    />

    <x-card 
        title="Nasi Rawon" 
        image="images/kuliner/nasirawon.jpg"
        description="Sup daging dengan kuah hitam dari keluak. Makanan khas Jawa Timur yang populer di area Bromo."
    />

    <x-card 
        title="Wedang Ronde" 
        image="images/kuliner/wedangronde.jpg"
        description="Minuman hangat berisi bola-bola ketan dengan jahe yang cocok untuk menghangatkan tubuh di suhu dingin Bromo."
    />

    <x-card 
        title="Tempe Kemul" 
        image="images/kuliner/tempekemul.jpg"
        description="Tempe goreng yang dibalut tepung berbumbu. Camilan renyah yang cocok dinikmati dalam perjalanan."
    />

    <x-card 
        title="Rujak Cingur" 
        image="images/kuliner/rujakcingur.jpg"
        description="Rujak khas Surabaya dengan cingur (hidung sapi) yang segar dengan bumbu petis yang khas."
    />

    <x-card 
        title="Lontong Balap" 
        image="images/kuliner/lontongbalap.jpg"
        description="Lontong dengan tauge, lentho, dan kuah kecap. Makanan khas Surabaya yang mudah ditemui di area Bromo."
    />
</div>

<!-- Warung Recommendation -->
<div class="mt-12 bg-[#b79393]/20 rounded-xl p-8 border border-[#b79393]">
    <h3 class="text-2xl font-bold text-[#042440] mb-4">Rekomendasi Tempat Makan</h3>
    <div class="space-y-4">
        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-[#4e499e]">
            <h4 class="font-semibold text-lg text-[#042440]">Warung Lestari - Ngadisari</h4>
            <p class="text-[#042440]/80">Spesialis: Sate Kelinci dan Rawon, buka 24 jam untuk wisatawan sunrise</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-[#4e499e]">
            <h4 class="font-semibold text-lg text-[#042440]">Rumah Makan Bromo Indah - Cemoro Lawang</h4>
            <p class="text-[#042440]/80">Menu lengkap khas Jawa Timur dengan view langsung ke Gunung Bromo</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-[#4e499e]">
            <h4 class="font-semibold text-lg text-[#042440]">Kedai Hangat - Wonokitri</h4>
            <p class="text-[#042440]/80">Tempat terbaik untuk menikmati wedang ronde dan jagung bakar</p>
        </div>
    </div>
</div>
@endsection
