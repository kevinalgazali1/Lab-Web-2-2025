@props(['active' => false])

@php
$classes = $active
    ? 'text-[#B793C9] font-semibold border-b-2 border-[#B793C9]'
    : 'text-[#A2BEDC] hover:text-[#B793C9] transition duration-200';
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
