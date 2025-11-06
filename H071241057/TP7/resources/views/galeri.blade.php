@extends('template.master') {{-- Mengubah layout ke template.master --}}

@section('title', 'Galeri Foto - Eksplor Makassar')

@section('content')
<div class="bg-gray-100 py-16 px-4">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-center text-[#222831] mb-2.5" data-aos="fade-up">Galeri Foto Makassar</h2>
        <div class="w-20 h-1 bg-[#00ADB5] rounded-sm mx-auto mb-12" data-aos="fade-up" data-aos-delay="100"></div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 lg:gap-8">

            <div class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="200">
                <img src="{{ asset('images/masjid-99kubah.jpg') }}" alt="Masjid 99 Kubah" class="w-full h-48 md:h-64 object-cover transform hover:scale-105 transition-transform duration-300">
                <div class="p-2 bg-white text-center text-xs text-gray-600">Masjid 99 Kubah</div>
            </div>

            <div class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="250">
                <img src="{{ asset('images/losari.jpg') }}" alt="Senja di Losari" class="w-full h-48 md:h-64 object-cover transform hover:scale-105 transition-transform duration-300">
                <div class="p-2 bg-white text-center text-xs text-gray-600">Malam di Pantai Losari</div>
            </div>

            <div class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="300">
                <img src="{{ asset('images/rotterdam.jpg') }}" alt="Benteng Rotterdam" class="w-full h-48 md:h-64 object-cover transform hover:scale-105 transition-transform duration-300">
                <div class="p-2 bg-white text-center text-xs text-gray-600">Fort Rotterdam</div>
            </div>
            
            <div class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="350">
                <img src="{{ asset('images/coto.jpg') }}" alt="Coto Makassar" class="w-full h-48 md:h-64 object-cover transform hover:scale-105 transition-transform duration-300">
                <div class="p-2 bg-white text-center text-xs text-gray-600">Coto Makassar</div>
            </div>
        
            <div class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="400">
                <img src="{{ asset('images/pinisi.jpg') }}" alt="Kapal Phinisi" class="w-full h-48 md:h-64 object-cover transform hover:scale-105 transition-transform duration-300">
                <div class="p-2 bg-white text-center text-xs text-gray-600">Kapal Phinisi</div>
            </div>
            
            <div class="overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="450">
                <img src="{{ asset('images/samalona.jpg') }}" alt="Pulau Samalona" class="w-full h-48 md:h-64 object-cover transform hover:scale-105 transition-transform duration-300">
                <div class="p-2 bg-white text-center text-xs text-gray-600">Pulau Samalona</div>
            </div>

        </div>
    </div>
</div>
@endsection