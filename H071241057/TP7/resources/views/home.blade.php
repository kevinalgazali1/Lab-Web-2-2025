@extends('template.master')

@section('content')

<div 
  class="relative flex h-screen items-center justify-center bg-cover bg-center" 
  style="background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e')">
  
  <div class="absolute inset-0 bg-black/50"></div>

  <div class="relative z-10 text-center text-white px-4">
    <h1 class="text-5xl font-bold">Eksplor Pariwisata Makassar</h1>
    <p class="mt-4 text-xl">Temukan Pesona Sejarah, Kuliner, dan Bahari di Jantung Sulawesi.</p>
    
    <a href="{{ url('/destinasi') }}" class="mt-8 inline-block rounded bg-blue-500 px-6 py-3 font-bold text-white transition duration-300 hover:bg-blue-600">
      Jelajahi Sekarang
    </a>
  </div>

</div>

<section class="text-center py-16 px-5 bg-[#EEEEEE]">
    
    <div class="max-w-3xl mx-auto mb-12" data-aos="fade-up">
        <h2 class="text-3xl font-bold text-[#222831] mb-2.5">Selamat Datang di Kota Daeng!</h2>
        <div class="w-20 h-1 bg-[#00ADB5] rounded-sm mx-auto mb-6"></div>
        <p class="text-gray-600 leading-relaxed">
            Makassar, yang juga dikenal sebagai Ujung Pandang, adalah ibu kota provinsi Sulawesi Selatan 
            dan menjadi pintu gerbang utama untuk kawasan Indonesia Timur. 
            Dikenal kaya akan sejarah, budaya yang kental, kuliner yang menggugah selera, 
            dan destinasi wisata bahari yang memukau. Website ini adalah panduan Anda 
            untuk menjelajahi setiap sudut keajaiban Kota Makassar.
        </p>
    </div>

    <h3 class="text-3xl font-bold text-[#222831] mb-2.5" data-aos="fade-up" data-aos-delay="100">Mengapa Harus ke Makassar?</h3>
    <div class="w-20 h-1 bg-[#00ADB5] rounded-sm mx-auto mb-10" data-aos="fade-up" data-aos-delay="200"></div>

    <div class="flex justify-center gap-8 flex-wrap">
        
        <div class="bg-white flex flex-col rounded-xl shadow-lg p-7 w-72 text-center items-center transition-transform duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl" data-aos="fade-up" data-aos-delay="300">
            <svg class="w-12 h-12 mb-5 text-[#00ADB5]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.287 8.287 0 0 0 3-2.553A8.252 8.252 0 0 1 15.362 5.214Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75A2.625 2.625 0 1 0 12 13.5a2.625 2.625 0 0 0 0 5.25Z" />
            </svg>
            <h3 class="text-xl font-semibold mb-2.5 text-[#222831]">Kuliner Otentik</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Cicipi Coto Makassar, Pallu Basa, dan Pisang Epe yang legendaris.</p>
        </div>
        
        <div class="bg-white flex flex-col rounded-xl shadow-lg p-7 w-72 text-center items-center transition-transform duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl" data-aos="fade-up" data-aos-delay="400">
            <svg class="w-12 h-12 mb-5 text-[#00ADB5]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
            </svg>
            <h3 class="text-xl font-semibold mb-2.5 text-[#222831]">Sejarah & Budaya</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Jelajahi Benteng Rotterdam dan saksikan tradisi di Anjungan Losari.</p>
        </div>

        <div class="bg-white flex flex-col rounded-xl shadow-lg p-7 w-72 text-center items-center transition-transform duration-300 ease-in-out hover:-translate-y-2 hover:shadow-xl" data-aos="fade-up" data-aos-delay="500">
            <svg class="w-12 h-12 mb-5 text-[#00ADB5]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-6.364-.386 1.591-1.591M3 12H.75m.386-6.364 1.591 1.591M12 6.375a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5Z" />
            </svg>
            <h3 class="text-xl font-semibold mb-2.5 text-[#222831]">Pesona Bahari</h3>
            <p class="text-sm text-gray-500 leading-relaxed">Nikmati pasir putih dan air jernih di Pulau Samalona & Kodingareng Keke.</p>
        </div>
        
    </div>
</section>
@endsection