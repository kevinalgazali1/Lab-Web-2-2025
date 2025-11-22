@props(['title', 'image', 'description', 'class' => ''])

<div class="rounded-xl overflow-hidden shadow-lg bg-[#B793C9] hover:shadow-2xl transition {{ $class }}">
    <img src="{{ asset($image) }}" alt="{{ $title }}" class="w-full h-56 object-cover">
    <div class="p-6">
        <h3 class="text-2xl font-bold text-[#4E499E] mb-3">{{ $title }}</h3>
        <p class="text-[#042440] leading-relaxed">{{ $description }}</p>
    </div>
</div>
