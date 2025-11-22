@extends('template.master')

@section('title', 'Kuliner Khas Makassar - Eksplor Makassar')

@section('content')
<div class="bg-gray-100 py-16 px-4">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-center text-[#222831] mb-2.5" data-aos="fade-up">Cita Rasa Khas Makassar</h2>
        <div class="w-20 h-1 bg-[#00ADB5] rounded-sm mx-auto mb-12" data-aos="fade-up" data-aos-delay="100"></div>

        {{-- Container untuk daftar kuliner --}}
        <div class="space-y-12 max-w-4xl mx-auto">

            {{-- Item Kuliner 1: Coto Makassar --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden md:flex transition-shadow duration-300 hover:shadow-xl" data-aos="fade-up" data-aos-delay="200">
                {{-- Gambar di Kiri (untuk layar md ke atas) --}}
                <div class="md:w-1/2">
                    <img src="{{ asset('images/coto1.jpg') }}" alt="Coto Makassar" class="w-full h-64 md:h-full object-cover"> {{-- Ganti dengan path gambar yang sesuai --}}
                </div>
                {{-- Deskripsi di Kanan --}}
                <div class="p-6 md:p-8 md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-semibold mb-3 text-[#222831]">Coto Makassar</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Soto legendaris dengan kuah kental kaya rempah, berisi potongan daging dan jeroan sapi. Nikmat disantap hangat bersama ketupat atau buras. Wajib dicoba saat berkunjung ke Makassar!
                    </p>
                    {{-- Bisa tambahkan info harga rata-rata atau rekomendasi tempat --}}
                    {{-- <p class="text-xs text-gray-500 mt-3">Estimasi Harga: Rp 25.000 - Rp 40.000</p> --}}
                </div>
            </div>

            {{-- Item Kuliner 2: Pallu Basa --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden md:flex transition-shadow duration-300 hover:shadow-xl" data-aos="fade-up" data-aos-delay="300">
                {{-- Gambar di Kanan (urutan div ditukar) --}}
                <div class="md:w-1/2 md:order-2">
                    <img src="https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?q=80&w=1914&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Pallu Basa" class="w-full h-64 md:h-full object-cover"> {{-- Ganti dengan path gambar yang sesuai --}}
                </div>
                <div class="p-6 md:p-8 md:w-1/2 md:order-1 flex flex-col justify-center">
                    <h3 class="text-2xl font-semibold mb-3 text-[#222831]">Pallu Basa</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Serupa tapi tak sama dengan Coto, Pallu Basa memiliki kuah lebih kental dari kelapa sangrai. Uniknya, sering disajikan dengan tambahan kuning telur mentah ('alas') yang diaduk langsung ke dalam kuah panas.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden md:flex transition-shadow duration-300 hover:shadow-xl" data-aos="fade-up" data-aos-delay="400">
                <div class="md:w-1/2">
                    <img src="{{ asset('images/pisangepe.jpg') }}" alt="Pisang Epe" class="w-full h-64 md:h-full object-cover"> {{-- Ganti dengan path gambar yang sesuai --}}
                </div>
                <div class="p-6 md:p-8 md:w-1/2 flex flex-col justify-center">
                    <h3 class="text-2xl font-semibold mb-3 text-[#222831]">Pisang Epe</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Jajanan manis favorit, terutama di sekitar Pantai Losari. Pisang kepok bakar yang dipipihkan ('epe'), lalu disiram saus gula merah cair yang legit. Kini tersedia juga varian topping modern seperti keju dan coklat.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
