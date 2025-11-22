@extends('layouts.master')

@section('title', 'Home')

@section('content')

<div class="container mx-auto px-6 py-6">
    <div class="relative h-screen flex items-center justify-center overflow-hidden rounded-2xl">
        <div class="absolute w-full h-full bg-cover bg-center bg-fixed z-0"
            style="background-image: url('{{ asset('images/hero-manado.jpg') }}');">
            <div class="absolute inset-0 bg-black opacity-40"></div>
        </div>
        <div class="relative z-10 text-center text-white px-6">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in">
                Selamat Datang di Kota Manado
            </h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-8 animate-fade-in-delay">
                Jelajahi keindahan "Kota Tinutuan", gerbang menuju surga bawah laut Bunaken
            </p>
            <a href="#explore" class="inline-block bg-white text-gray-900 px-8 py-3 rounded-full font-semibold 
                    hover:bg-gray-100 transition duration-300 transform hover:scale-105 animate-bounce">
                Jelajahi Sekarang
            </a>
        </div>
        <div class="absolute bottom-10 left-0 right-0 text-center">
            <a href="#explore" class="text-white">
                <i class="fas fa-chevron-down text-3xl animate-bounce"></i>
            </a>
        </div>
    </div>
</div>
<div id="explore" class="container mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <x-card-explore 
            title="Destinasi Wisata"
            description="Temukan keindahan alam Manado, dari Taman Nasional Bunaken hingga Gunung Lokon."
            image="{{ asset('images/bunaken.jpg') }}"
            route="{{ route('destinasi') }}"
        />

        <x-card-explore 
            title="Kuliner Khas"
            description="Rasakan sensasi kuliner khas Manado yang pedas dan menggugah selera."
            image="{{ ('https://asset.kompas.com/crops/GZP1r3C5qNg_J8bgVzQtupnPoBs=/81x22:892x563/1200x800/data/photo/2020/05/13/5ebbdec618a37.jpg') }}"
            route="{{ route('kuliner') }}"
        />

        <x-card-explore 
            title="Galeri"
            description="Ekslorasi keindahan lainnya dari Kota Manado."
            image="{{ asset('https://i.pinimg.com/1200x/af/86/f2/af86f2637ad6d3b10f250bae46e8d9ec.jpg') }}"
            route="{{ route('galeri') }}"
        />

        
    </div>
</div>
<div class="container mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
        @php
        $stats = [
        ['count' => 50, 'prefix' => '>', 'label' => 'Destinasi Wisata'],
        ['count' => 100, 'suffix' => '+', 'label' => 'Kuliner Khas'],
        ['count' => 25, 'prefix' => '±', 'label' => 'Festival Tahunan'],
        ['count' => 1000, 'prefix' => '>', 'label' => 'Hotel & Penginapan']
        ];
        @endphp

        @foreach($stats as $stat)
        <div class="p-6 group hover:scale-105 transition-all duration-300">
            <div class="text-5xl font-bold text-brand-dark mb-2"
                data-count="{{ $stat['count'] }}"
                data-prefix="{{ $stat['prefix'] ?? '' }}"
                data-suffix="{{ $stat['suffix'] ?? '' }}">0</div>
            <div class="text-gray-600 group-hover:text-brand-dark transition-colors duration-300">
                {{ $stat['label'] }}
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="container mx-auto px-6 mb-12">
    <div class="bg-brand-dark text-brand-light py-16 rounded-2xl text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Mengunjungi Manado?</h2>
        <p class="text-xl mb-8">Hubungi kami untuk informasi lebih lanjut tentang wisata di Manado</p>
        <a href="{{ route('kontak') }}" class="inline-block bg-brand-light text-brand-dark px-8 py-3 rounded-full font-semibold 
                hover:bg-opacity-90 transition duration-300 transform hover:scale-105">
            Hubungi Kami
        </a>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                const headerHeight = document.querySelector('header').offsetHeight;

                if (targetElement) {
                    const elementPosition = targetElement.offsetTop - headerHeight;
                    window.scroll({
                        top: elementPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        
        const counterElements = document.querySelectorAll('[data-count]');

        function animateValue(element, start, end, duration) {
            let startTimestamp = null;
            const prefix = element.getAttribute('data-prefix') || '';
            const suffix = element.getAttribute('data-suffix') || '';

            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const currentValue = Math.floor(progress * (end - start) + start);

                const formattedNumber = currentValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                element.innerHTML = `${prefix}${formattedNumber}${suffix}`;

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const count = parseInt(target.getAttribute('data-count'));
                    animateValue(target, 0, count, 2000);
                    observer.unobserve(target);
                }
            });
        }, {
            threshold: 0.5
        });

        counterElements.forEach(counter => observer.observe(counter));
    });
</script>
@endpush

@endsection