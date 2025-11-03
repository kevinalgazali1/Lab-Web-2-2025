@extends('layouts.master')

@section('content')
<!-- Hero Section -->
<section class="hero min-h-screen flex flex-col justify-center items-center text-center text-white px-5 pt-16 pb-8">
    <div class="hero-content max-w-4xl">
        <h2 class="hero-subtitle text-3xl md:text-4xl font-bold mb-6 
            bg-gradient-to-r from-red-400 via-yellow-300 to-red-500 bg-clip-text text-transparent drop-shadow-[0_2px_6px_rgba(0,0,0,0.4)]">
            SELAMAT DATANG<br>DI JAYAPURA, PAPUA
        </h2>
        
        <p class="hero-description text-lg md:text-xl mb-8 opacity-90 leading-relaxed max-w-2xl mx-auto">
            Menjelajahi keindahan alam dan kekayaan budaya Kota Jayapura, 
            gerbang menuju pesona Papua yang memukau dengan pantai eksotis, 
            pegunungan hijau, dan kuliner autentik.
        </p>
        
        <a href="{{ url('/destinasi') }}" 
           class="cta-button inline-block bg-red-500/90 text-white px-8 py-3 rounded-full font-semibold transition-all duration-300 backdrop-blur-sm shadow-lg hover:bg-red-500 hover:translate-y-[-2px] hover:shadow-xl">
            Mulai Jelajahi
        </a>
    </div>
</section>

<!-- Kenangan Section -->
<section class="kenangan-section py-16 bg-white/95 backdrop-blur-lg">
    <div class="container max-w-6xl mx-auto px-5">
        <h2 class="kenangan-title text-3xl font-bold text-center text-gray-800 mb-12">Kenangan di Jayapura</h2>
        
        <div class="kenangan-grid grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            
            <!-- Video Pantai -->
            <div class="kenangan-item rounded-2xl overflow-hidden shadow-2xl transition-all duration-300 hover:translate-y-[-5px] hover:shadow-3xl relative">
                <div class="video-wrapper relative w-full h-48 rounded-2xl overflow-hidden group">
                    <video class="w-full h-full object-cover" muted loop>
                        <source src="/video/pantai-base-g.mp4" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                    
                    <!-- Overlay saat hover -->
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="play-btn bg-red-500/80 text-white w-14 h-14 rounded-full flex items-center justify-center text-2xl">
                            <i class="fas fa-play"></i>
                        </button>
                    </div>

                    <!-- Tombol Mute -->
                    <button class="mute-btn absolute bottom-3 left-3 bg-black/70 text-white w-10 h-10 rounded-full flex items-center justify-center transition hover:bg-red-500/80">
                        <i class="fas fa-volume-mute"></i>
                    </button>
                </div>
            </div>

            <!-- Foto Pegunungan -->
            <div class="kenangan-item rounded-2xl overflow-hidden shadow-2xl transition-all duration-300 hover:translate-y-[-5px] hover:shadow-3xl h-48">
                <img src="/image/friend(2).jpg" 
                     alt="My Friend" 
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
            </div>
            
            <!-- Foto Kuliner -->
            <div class="kenangan-item rounded-2xl overflow-hidden shadow-2xl transition-all duration-300 hover:translate-y-[-5px] hover:shadow-3xl h-48">
                <img src="/image/friend(1).jpg" 
                     alt="My Friend" 
                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
            </div>
        </div>
    </div>
</section>

<!-- Maps Section -->
<section class="maps-section py-16 bg-gray-50/95 backdrop-blur-lg">
    <div class="maps-container max-w-5xl mx-auto px-5">
        <h2 class="maps-title text-3xl font-bold text-center text-gray-800 mb-12">Peta Kota Jayapura</h2>
        
        <div class="maps-wrapper rounded-2xl overflow-hidden shadow-2xl h-96">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127672.475266227!2d140.60843095!3d-2.5483999499999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x686c7e35bb464b67%3A0x3039d80b220cc60!2sJayapura%2C%20Jayapura%20City%2C%20Papua!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                class="w-full h-full border-0"
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        
        <p class="maps-caption text-center mt-4 text-gray-600 text-sm">
            Lokasi strategis Kota Jayapura di Papua, Indonesia
        </p>
    </div>
</section>

<!-- Script kontrol video -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const video = document.querySelector(".video-wrapper video");
    const playBtn = document.querySelector(".play-btn");
    const muteBtn = document.querySelector(".mute-btn");

    let isPlaying = false;

    // Video tidak autoplay dan tetap mute
    video.muted = true;
    video.pause();

    // Tombol play/pause
    playBtn.addEventListener("click", () => {
        if (isPlaying) {
            video.pause();
            playBtn.innerHTML = '<i class="fas fa-play"></i>';
        } else {
            video.play();
            playBtn.innerHTML = '<i class="fas fa-pause"></i>';
        }
        isPlaying = !isPlaying;
    });

    // Tombol mute/unmute
    muteBtn.addEventListener("click", () => {
        video.muted = !video.muted;
        muteBtn.innerHTML = video.muted
            ? '<i class="fas fa-volume-mute"></i>'
            : '<i class="fas fa-volume-up"></i>';
    });
});
</script>
@endsection