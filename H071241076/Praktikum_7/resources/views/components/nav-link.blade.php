@props(['href'])

@php
$isActive = ($href === '/') ? Request::is('/') : Request::is(ltrim($href, '/'));
@endphp

<a href="{{ $href }}"
    class="
        px-3 py-2 rounded-md text-sm font-medium transition-colors
        
        @if ($isActive)
            text-white  /* Ini class untuk link AKTIF (warna hover) */
        @else
            text-brand-light/70 hover:text-white /* Ini class untuk link TIDAK AKTIF */
        @endif
    ">
    {{ $slot }}
</a>