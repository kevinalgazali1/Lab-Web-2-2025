@extends('layouts.master')

@section('content')
<!-- Page Header -->
<section class="page-header py-32 text-center text-white bg-black/60 backdrop-blur-sm">
    <div class="container max-w-4xl mx-auto px-5">
        <h1 class="text-4xl font-bold mb-4">Destinasi Wisata Jayapura</h1>
        <p class="text-xl opacity-90">Temukan keindahan alam dan budaya Jayapura yang menakjubkan</p>
    </div>
</section>

<!-- Destinations Grid -->
<section class="destinations py-16 bg-white/95 backdrop-blur-lg">
    <div class="container max-w-7xl mx-auto px-5">
        <div class="cards-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Destinasi 1 -->
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:translate-y-[-3px] hover:shadow-xl">
                <div class="card-image h-40 overflow-hidden">
                    <img src="/image/jembatan-merah.jpg"
                         alt="Jembatan Merah Jayapura"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="card-content p-4">
                    <h3 class="card-title text-lg font-semibold text-gray-800 mb-2">Jembatan Merah</h3>
                    <p class="card-description text-gray-600 text-sm leading-relaxed">
                        Jembatan Merah Jayapura berdiri gagah di atas Teluk Youtefa, memantulkan cahaya senja yang menawan dan menjadi saksi keindahan kota di ufuk timur Indonesia.
                    </p>
                </div>
            </div>

            <!-- Destinasi 2 -->
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:translate-y-[-3px] hover:shadow-xl">
                <div class="card-image h-40 overflow-hidden">
                    <img src="/image/taman-dok8.jpg"
                         alt="Taman Dok 8"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="card-content p-4">
                    <h3 class="card-title text-lg font-semibold text-gray-800 mb-2">Taman Dok 8</h3>
                    <p class="card-description text-gray-600 text-sm leading-relaxed">
                        Taman Dok 8 Jayapura menawarkan suasana tepi laut yang tenang dengan pemandangan kota dan teluk yang menawan, tempat favorit warga dan wisatawan untuk bersantai.
                    </p>
                </div>
            </div>

            <!-- Destinasi 3 -->
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:translate-y-[-3px] hover:shadow-xl">
                <div class="card-image h-40 overflow-hidden">
                    <img src="/image/bukit-teletabis.jpg"
                         alt="Bukit Teletubbies"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="card-content p-4">
                    <h3 class="card-title text-lg font-semibold text-gray-800 mb-2">Bukit Teletubbies</h3>
                    <p class="card-description text-gray-600 text-sm leading-relaxed">
                        Bukit Teletabis Jayapura menghadirkan hamparan perbukitan hijau yang menenangkan, tempat ideal menikmati panorama alam dan udara segar khas Papua.
                    </p>
                </div>
            </div>

            <!-- Destinasi 4 -->
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:translate-y-[-3px] hover:shadow-xl">
                <div class="card-image h-40 overflow-hidden">
                    <img src="/image/Bukit-Jokowi.jpg"
                         alt="Bukit Jokowi"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="card-content p-4">
                    <h3 class="card-title text-lg font-semibold text-gray-800 mb-2">Bukit Jokowi</h3>
                    <p class="card-description text-gray-600 text-sm leading-relaxed">
                        Dari Bukit Jokowi, keindahan Jayapura terlihat utuh—hamparan laut, pegunungan, dan langit yang seakan berpadu menciptakan pemandangan yang menenangkan hati.
                    </p>
                </div>
            </div>

            <!-- Destinasi 5 -->
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:translate-y-[-3px] hover:shadow-xl">
                <div class="card-image h-40 overflow-hidden">
                    <img src="/image/pantai base-g(2).jpg"
                         alt="Pantai Base-G"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="card-content p-4">
                    <h3 class="card-title text-lg font-semibold text-gray-800 mb-2">Pantai Base-G</h3>
                    <p class="card-description text-gray-600 text-sm leading-relaxed">
                        Dikelilingi pepohonan hijau dan ombak lembut, Pantai Base-G menjadi tempat ideal untuk menikmati keindahan alam Papua sambil merasakan semilir angin laut yang menyejukkan.
                    </p>
                </div>
            </div>

            <!-- Destinasi 6 -->
            <div class="card bg-white rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:translate-y-[-3px] hover:shadow-xl">
                <div class="card-image h-40 overflow-hidden">
                    <img src="/image/danau_love.jpg"
                         alt="Danau Love"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>
                <div class="card-content p-4">
                    <h3 class="card-title text-lg font-semibold text-gray-800 mb-2">Danau Love</h3>
                    <p class="card-description text-gray-600 text-sm leading-relaxed">
                        Danau Love Sentani menghadirkan pesona alam yang menenangkan dengan bentuk hati yang unik, dikelilingi perbukitan hijau dan udara segar khas Papua yang memanjakan setiap pandangan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection