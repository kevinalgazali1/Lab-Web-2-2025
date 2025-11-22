@extends('template.master')

@section('title', 'Hubungi Kami - Eksplor Makassar')

@section('content')
<div class="bg-gray-100 py-16 px-4">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-center text-[#222831] mb-2.5" data-aos="fade-up">Hubungi Kami</h2>
        <div class="w-20 h-1 bg-[#00ADB5] rounded-sm mx-auto mb-12" data-aos="fade-up" data-aos-delay="100"></div>

        <div class="bg-white rounded-xl shadow-lg p-8 md:p-12 max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                {{-- Kolom Informasi Kontak --}}
                <div data-aos="fade-right" data-aos-delay="200">
                    <h3 class="text-xl font-semibold mb-4 text-[#222831]">Informasi Kontak</h3>
                    <p class="text-gray-600 mb-3">
                        Punya pertanyaan, saran, atau ingin berkolaborasi? Jangan ragu untuk menghubungi kami melalui detail di bawah ini.
                    </p>
                    <div class="space-y-3 text-sm">
                        <p class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-1 text-[#00ADB5] shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            <span>Jl. Pariwisata Indah No. 45,<br>Makassar, Sulawesi Selatan, 90222</span>
                        </p>
                        <p class="flex items-center">
                             <svg class="w-4 h-4 mr-2 text-[#00ADB5] shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            <a href="mailto:info@eksplormakassar.com" class="text-blue-500 hover:text-blue-700">info@eksplormakassar.com</a>
                        </p>
                        <p class="flex items-center">
                           <svg class="w-4 h-4 mr-2 text-[#00ADB5] shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                            <span>(0411) 555-1234</span>
                        </p>
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="300">
                    <h3 class="text-xl font-semibold mb-4 text-[#222831]">Kirim Pesan</h3>
                    <form action="#" method="POST" onsubmit="alert('Fitur ini belum berfungsi.'); return false;"> {{-- Aksi form sementara --}}
                        @csrf
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Anda</label>
                            <input type="text" id="nama" name="nama" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Anda</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="mb-4">
                            <label for="pesan" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea id="pesan" name="pesan" rows="4" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            <button type="submit"
                                    class="inline-block rounded bg-blue-500 px-6 py-2.5 font-bold text-white transition duration-300 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection