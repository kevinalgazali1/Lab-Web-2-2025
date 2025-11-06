@extends('template.master')

@section('title', $namaDestinasi . ' - Detail Destinasi - Eksplor Makassar')

@section('content')
<div class="bg-white py-12 px-4">
    <div class="container mx-auto max-w-4xl">

        <div class="mb-8 rounded-lg overflow-hidden shadow-lg" data-aos="fade-in">
            <img src="{{ $gambarUrl }}" alt="{{ $namaDestinasi }}" class="w-full h-64 md:h-96 object-cover">
        </div>

        <h1 class="text-3xl md:text-4xl font-bold text-[#222831] mb-4" data-aos="fade-up">{{ $namaDestinasi }}</h1>
        <p class="text-gray-600 leading-relaxed mb-6" data-aos="fade-up" data-aos-delay="100">
            {{ $deskripsiLengkap }}
        </p>

        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-xl font-semibold mb-3 text-[#222831]">Informasi Tambahan</h3>
            <ul class="list-disc list-inside text-gray-700 text-sm space-y-1">
                <li><strong>Lokasi:</strong> {{ $lokasi }}</li>
                <li><strong>Jam Buka:</strong> {{ $jamBuka }}</li>
                <li><strong>Tiket Masuk:</strong> {{ $tiket }}</li>
                {{-- Tambahkan info lain jika perlu --}}
            </ul>
        </div>

        <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ url('/destinasi') }}" class="inline-block rounded bg-gray-500 px-6 py-2.5 font-bold text-white transition duration-300 hover:bg-gray-600">
                &larr; Kembali ke Daftar Destinasi
            </a>
        </div>

    </div>
</div>
@endsection

