@extends('layouts.master')

@section('title', 'Kontak')

@section('content')
<div class="max-w-4xl mx-auto">
    <section class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Hubungi Kami</h1>
        <p class="text-xl text-gray-600">Butuh informasi lebih lanjut tentang wisata di Toraja?</p>
    </section>

    <div class="grid md:grid-cols-1 gap-12">
        <!-- Form Kirim Pesan - DI ATAS -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Kirim Pesan</h2>
            <form class="space-y-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Masukkan nama lengkap"
                    >
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="email@contoh.com"
                    >
                </div>

                <div>
                    <label for="subjek" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                    <input 
                        type="text" 
                        id="subjek" 
                        name="subjek" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Subjek pesan"
                    >
                </div>

                <div>
                    <label for="pesan" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                    <textarea 
                        id="pesan" 
                        name="pesan" 
                        rows="5" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Tulis pesan Anda di sini..."
                    ></textarea>
                </div>

                <button type="submit" class="w-full bg-red-900 hover:bg-red-800 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 text-center">
                    Kirim Pesan
                </button>
            </form>
        </div>

        <!-- Informasi Kontak - DI BAWAH -->
        <div class=>
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Informasi Kontak</h2>
            
            <div class="space-y-6 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="text-2xl text-red-900">📍</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">Alamat</h3>
                        <p class="text-gray-600">Jl. Nusantara No. 45, Makale, Toraja Utara 91811, Sulawesi Selatan</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="text-2xl text-red-900">📞</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">Telepon</h3>
                        <p class="text-gray-600">+62 823 4567 8901</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4">
                    <div class="text-2xl text-red-900">✉️</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">Email</h3>
                        <p class="text-gray-600">info@torajaterindah.com</p>
                    </div>
                </div>
                

            <!-- Social Media -->
            <div class=" pt-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Ikuti Kami</h3>
                <div class="flex justify-center space-x-4">
                    <a href="#" class=" text-black px-4 py-2 rounded-lg ">
                        <span>📘</span>
                        <span>Facebook</span>
                    </a>
                    <a href="#" class= "text-black px-4 py-2 rounded-lg ">
                        <span>📷</span>
                        <span>Instagram</span>
                    </a>
                    <a href="#" class=" text-black px-4 py-2 rounded-lg ">
                        <span>🐦</span>
                        <span>Twitter</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection