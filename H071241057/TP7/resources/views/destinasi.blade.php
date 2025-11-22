@extends('template.master')

@section('title', 'Destinasi Wisata - Eksplor Makassar')

@section('content')
<div class="bg-gray-100 py-16 px-4">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-center text-[#222831] mb-2.5" data-aos="fade-up">Destinasi Populer di Makassar</h2>
        <div class="w-20 h-1 bg-[#00ADB5] rounded-sm mx-auto mb-12" data-aos="fade-up" data-aos-delay="100"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @isset($destinasiList)
                @forelse ($destinasiList as $destinasi)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-transform duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 200 }}">
                    <img src="{{ $destinasi['gambar'] ?? asset('images/placeholder.jpg') }}" alt="{{ $destinasi['nama'] ?? 'Nama Destinasi' }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2 text-[#222831]">{{ $destinasi['nama'] ?? 'Nama Destinasi' }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">
                            {{ $destinasi['deskripsi_singkat'] ?? 'Deskripsi singkat destinasi akan muncul di sini.' }}
                        </p>
                        {{-- Tautan ke halaman detail menggunakan route name dan slug --}}
                        <a href="{{ isset($destinasi['slug']) ? route('destinasi.show', ['slug' => $destinasi['slug']]) : '#' }}" class="inline-block mt-4 text-sm text-blue-500 hover:text-blue-700">
                            Lihat Detail &rarr;
                        </a>
                    </div>
                </div>
                @empty
                    <p class="text-center text-gray-500 col-span-full">Belum ada data destinasi yang tersedia.</p>
                @endforelse
            @else
                {{-- Fallback jika $destinasiList tidak ada --}}
                 <p class="text-center text-gray-500 col-span-full">Gagal memuat data destinasi.</p>
            @endisset

        </div>
    </div>
</div>
@endsection
