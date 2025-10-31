<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplor Manado - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-dark': '#0f3a3a',
                        'brand-light': '#f5f0e8',
                        'brand-gray': '#a1a1aa',
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex-grow: 1;
        }

        /* Definisi animasi (Untuk Halaman Home Anda) */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-fade-in-delay {
            animation: fadeIn 1s ease-out 0.5s forwards;
            opacity: 0;
            /* Mulai dari transparan */
        }
    </style>
</head>

<body class="bg-brand-light text-gray-800">

    <header class="sticky top-0 z-50 bg-brand-dark/70 backdrop-blur-lg shadow-md">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">

            <div>
                <a href="/" class="text-white text-2xl font-bold">
                    Eksplor Kota Manado
                </a>
            </div>

            <div class="space-x-4">
                <x-nav-link href="/">Home</x-nav-link>
                <x-nav-link href="/destinasi">Destinasi</x-nav-link>
                <x-nav-link href="/kuliner">Kuliner</x-nav-link>
                <x-nav-link href="/galeri">Galeri</x-nav-link>
                <x-nav-link href="/kontak">Kontak</x-nav-link>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>

    <footer class="bg-brand-dark text-brand-light/70 p-4 text-center mt-auto">
        <p>&copy; 2025 Eksplor Manado. Dibuat dengan cinta.</p>
    </footer>

    @stack('scripts')
</body>

</html>