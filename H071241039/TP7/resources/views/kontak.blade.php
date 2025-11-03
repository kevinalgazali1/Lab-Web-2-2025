@extends('layouts.master')

@section('content')
<!-- Page Header -->
<section class="page-header py-32 text-center text-white bg-black/60 backdrop-blur-sm">
    <div class="container max-w-4xl mx-auto px-5">
        <h1 class="text-4xl font-bold mb-4">Kontak Kami</h1>
        <p class="text-xl opacity-90">Hubungi kami untuk informasi lebih lanjut tentang wisata Jayapura</p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact py-16 bg-white/95 backdrop-blur-lg">
    <div class="container max-w-6xl mx-auto px-5">
        <div class="contact-grid grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="contact-info">
                <h2 class="text-2xl font-bold text-gray-800 mb-8">Informasi Kontak</h2>
                
                <div class="contact-item flex items-start gap-4 mb-6">
                    <i class="fas fa-map-marker-alt text-red-500 text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Alamat</h3>
                        <p class="text-gray-600">Jl. BTN Puskopad Atas, Jayapura, Papua</p>
                    </div>
                </div>
                
                <div class="contact-item flex items-start gap-4 mb-6">
                    <i class="fas fa-phone text-red-500 text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Telepon</h3>
                        <p class="text-gray-600">+62 821 9824xxx</p>
                    </div>
                </div>
                
                <div class="contact-item flex items-start gap-4 mb-6">
                    <i class="fas fa-envelope text-red-500 text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                        <p class="text-gray-600">info@jayapuraexplorer.com</p>
                    </div>
                </div>
                
                <div class="contact-item flex items-start gap-4">
                    <i class="fas fa-clock text-red-500 text-xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Jam Operasional</h3>
                        <p class="text-gray-600">Senin - Minggu: 08:00 - 17:00 WIT</p>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="contact-form">
                <h2 class="text-2xl font-bold text-gray-800 mb-8">Kirim Pesan</h2>
                <form class="space-y-6">
                    <div class="form-group">
                        <input type="text" 
                               placeholder="Nama Lengkap" 
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 transition-colors">
                    </div>
                    
                    <div class="form-group">
                        <input type="email" 
                               placeholder="Email" 
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 transition-colors">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" 
                               placeholder="Subjek" 
                               required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 transition-colors">
                    </div>
                    
                    <div class="form-group">
                        <textarea placeholder="Pesan Anda" 
                                  rows="5" 
                                  required
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-red-500 transition-colors resize-none"></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="submit-btn bg-gradient-to-r from-red-500 to-red-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 hover:from-red-600 hover:to-red-700 hover:translate-y-[-2px] shadow-lg">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection