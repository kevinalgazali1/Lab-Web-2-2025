<div class="bg-white rounded-lg shadow-lg overflow-hidden transform transition duration-500 hover:scale-105">
    <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $image }}')"></div>
    <div class="p-6 flex flex-col min-h-[200px]">
        <div class="grow">
            <h3 class="text-2xl font-bold mb-3 text-brand-dark">{{ $title }}</h3>
            <p class="text-gray-600 mb-4">{{ $description }}</p>
        </div>
        <a href="{{ $route }}" class="text-brand-dark hover:text-opacity-70 font-semibold mt-auto">Explore →</a>
    </div>
</div>
