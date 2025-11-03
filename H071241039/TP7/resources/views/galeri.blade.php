@extends('layouts.master')

@section('content')
<!-- Page Header -->
<section class="page-header py-32 text-center text-white bg-black/60 backdrop-blur-sm">
    <div class="container max-w-4xl mx-auto px-5">
        <h1 class="text-4xl font-bold mb-4">Galeri Jayapura</h1>
        <p class="text-xl opacity-90">Kumpulan momen indah dan pemandangan menakjubkan dari Kota Jayapura</p>
    </div>
</section>

<!-- Gallery Grid -->
<section class="gallery py-16 bg-gray-50/95 backdrop-blur-lg">
    <div class="container max-w-7xl mx-auto px-5">
        <div class="gallery-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Foto 1 -->
            <div class="gallery-item relative rounded-lg overflow-hidden shadow-lg cursor-pointer h-44">
                <img src="/image/Sunset-Yobe-Sentani.png" 
                     alt="Sunset di Yobe Sentani"
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                <div class="gallery-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-3 transform translate-y-full transition-transform duration-300">
                    <p class="text-sm font-medium">Sunset di Yobe Sentani</p>
                </div>
            </div>
            
            <!-- Foto 2 -->
            <div class="gallery-item relative rounded-lg overflow-hidden shadow-lg cursor-pointer h-44">
                <img src="/image/sunset-hamadi.jpg" 
                     alt="Sunset di Pantai Hamadi"
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                <div class="gallery-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-3 transform translate-y-full transition-transform duration-300">
                    <p class="text-sm font-medium">Sunset di Pantai Hamadi</p>
                </div>
            </div>
            
            <!-- Foto 3 -->
            <div class="gallery-item relative rounded-lg overflow-hidden shadow-lg cursor-pointer h-44">
                <img src="/image/jayapura-city.jpg" 
                     alt="Jayapura City"
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                <div class="gallery-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-3 transform translate-y-full transition-transform duration-300">
                    <p class="text-sm font-medium">Jayapura City</p>
                </div>
            </div>
            
            <!-- Foto 4 -->
            <div class="gallery-item relative rounded-lg overflow-hidden shadow-lg cursor-pointer h-44">
                <img src="/image/Yospan.jpg" 
                     alt="Tarian Tradisional"
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                <div class="gallery-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-3 transform translate-y-full transition-transform duration-300">
                    <p class="text-sm font-medium">Tarian Tradisional Yospan</p>
                </div>
            </div>
            
            <!-- Foto 5 -->
            <div class="gallery-item relative rounded-lg overflow-hidden shadow-lg cursor-pointer h-44">
                <img src="/image/tifa.jpg" 
                     alt="Tifa"
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                <div class="gallery-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-3 transform translate-y-full transition-transform duration-300">
                    <p class="text-sm font-medium">Alat Musik Tifa</p>
                </div>
            </div>
            
            <!-- Foto 6 -->
            <div class="gallery-item relative rounded-lg overflow-hidden shadow-lg cursor-pointer h-44">
                <img src="/image/mal-jayapura.jpg" 
                     alt="Mall Jayapura"
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                <div class="gallery-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-3 transform translate-y-full transition-transform duration-300">
                    <p class="text-sm font-medium">Mall Jayapura</p>
                </div>
            </div>
            
            <!-- Foto 7 -->
            <div class="gallery-item relative rounded-lg overflow-hidden shadow-lg cursor-pointer h-44">
                <img src="/image/gunung-cycloop.png" 
                     alt="Pegunungan Cyclops"
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                <div class="gallery-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-3 transform translate-y-full transition-transform duration-300">
                    <p class="text-sm font-medium">Pegunungan Cyclops</p>
                </div>
            </div>
            
            <!-- Foto 8 -->
            <div class="gallery-item relative rounded-lg overflow-hidden shadow-lg cursor-pointer h-44">
                <img src="/image/taman-imbi.jpg" 
                     alt="Taman Imbi"
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                <div class="gallery-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent text-white p-3 transform translate-y-full transition-transform duration-300">
                    <p class="text-sm font-medium">Taman Imbi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Hover effect for gallery items
    document.addEventListener('DOMContentLoaded', function() {
        const galleryItems = document.querySelectorAll('.gallery-item');
        
        galleryItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.querySelector('.gallery-overlay').classList.remove('translate-y-full');
            });
            
            item.addEventListener('mouseleave', function() {
                this.querySelector('.gallery-overlay').classList.add('translate-y-full');
            });
        });
    });
</script>
@endsection