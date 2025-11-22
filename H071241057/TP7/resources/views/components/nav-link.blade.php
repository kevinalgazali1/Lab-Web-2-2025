@props(['url'])

@php
$active = request()->is( ltrim($url, '/') ?: '/' ); 
$onHome = request()->is('/'); // Variabel baru: cek apa kita di Home
@endphp

<a href="{{ $url }}" 
   @class([
       // Style JIKA AKTIF (halaman sedang dibuka)
       'font-bold' => $active,
       'text-white' => $active && $onHome,      // Aktif di Home -> Putih
       'text-blue-600' => $active && !$onHome,   // Aktif BUKAN di Home -> Biru

       // Style JIKA TIDAK AKTIF
       'font-normal' => !$active,
       'text-white hover:text-gray-300' => !$active && $onHome,    // Tidak Aktif di Home
       'text-gray-700 hover:text-blue-600' => !$active && !$onHome  // Tidak Aktif BUKAN di Home
   ])
>
    {{ $slot }}
</a>