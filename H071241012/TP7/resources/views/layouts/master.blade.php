<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplor Pariwisata Toraja - @yield('title', 'Home')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .nav-active {
            background-color: #7f1d1d;
            color: white;
        }
        /* Pastikan html dan body mengambil full height */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        /* Header tetap di atas */
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        /* Footer tetap di bawah */
        .sticky-footer {
            margin-top: auto;
        }
        /* Main content bisa scroll */
        .main-content {
            flex: 1;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header - STICKY -->
    <header class="bg-red-900 text-white shadow-lg sticky-header">
        <div class="container mx-auto px-2 py-2">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <span class="text-red-900 font-bold text-lg">T</span>
                    </div>
                    <h1 class="text-2xl font-bold">Toraja Terindah</h1>
                </div>
                
                <nav class="w-full md:w-auto">
                    <ul class="flex flex-wrap justify-center space-x-1">
                        <li>
                            <a href="/" class="px-4 py-2 rounded-lg transition-colors duration-200 font-medium {{ request()->is('/') ? 'nav-active' : 'hover:bg-red-800' }}">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="/destinasi" class="px-4 py-2 rounded-lg transition-colors duration-200 font-medium {{ request()->is('destinasi') ? 'nav-active' : 'hover:bg-red-800' }}">
                                Destinasi
                            </a>
                        </li>
                        <li>
                            <a href="/kuliner" class="px-4 py-2 rounded-lg transition-colors duration-200 font-medium {{ request()->is('kuliner') ? 'nav-active' : 'hover:bg-red-800' }}">
                                Kuliner
                            </a>
                        </li>
                        <li>
                            <a href="/galeri" class="px-4 py-2 rounded-lg transition-colors duration-200 font-medium {{ request()->is('galeri') ? 'nav-active' : 'hover:bg-red-800' }}">
                                Galeri
                            </a>
                        </li>
                        <li>
                            <a href="/kontak" class="px-4 py-2 rounded-lg transition-colors duration-200 font-medium {{ request()->is('kontak') ? 'nav-active' : 'hover:bg-red-800' }}">
                                Kontak
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content - BISA SCROLL -->
    <main class="main-content container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer - STICKY DI BAWAH (LEBIH KECIL) -->
    <footer class="bg-red-900 text-white py-4 sticky-footer">
        <div class="container mx-auto px-4 text-center">
            <div class="mb-2">
                <h3 class="text-base font-bold">Toraja Terindah</h3>
                <p class="text-red-200 text-sm">Menjelajahi Keindahan dan Keunikan Toraja</p>
            </div>
            <div class="border-t border-red-700 pt-2">
                <p class="text-xs text-red-300">&copy; 2024 Eksplor Pariwisata Toraja. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>