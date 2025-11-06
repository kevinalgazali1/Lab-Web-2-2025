<nav @class([
        '',
        'w-full transition-all duration-300', 
        
        'absolute top-0 left-0 z-20 bg-transparent text-white' => request()->is('/'), 

        'sticky top-0 bg-white text-gray-800 shadow-md' => ! request()->is('/')
    ])>
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                
                <div>
                    <a href="/"
                    @class([
                    'text-2xl font-bold',
                    'hover:text-gray-300' => request()->is('/'), 
                    'hover:text-blue-600' => ! request()->is('/') 
                    ])>Makassar</a>
                </div>

                <div class="hidden md:flex space-x-6">
                    <x-nav-link url="/">Home</x-nav-link>
                    <x-nav-link url="/destinasi">Destinasi</x-nav-link>
                    <x-nav-link url="/kuliner">Kuliner</x-nav-link>
                    <x-nav-link url="/galeri">Galeri</x-nav-link>
                    <x-nav-link url="/contact">Kontak</x-nav-link>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="focus:outline-none">
                        <svg id="icon-open" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg id="icon-close" class="w-6 h-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden px-4 pb-4">
            <a href="/" class="block py-2 text-sm hover:bg-gray-700 rounded">Home</a>
            <a href="/destinasi" class="block py-2 text-sm hover:bg-gray-700 rounded">Destinasi</a>
            <a href="/kuliner" class="block py-2 text-sm hover:bg-gray-700 rounded">Kuliner</a>
            <a href="/galeri" class="block py-2 text-sm hover:bg-gray-700 rounded">Galeri</a>
            <a href="/contact" class="block py-2 text-sm hover:bg-gray-700 rounded">Kontak</a>
        </div>
    </nav>

    <script>
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('icon-open');
        const iconClose = document.getElementById('icon-close');

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });
    </script>