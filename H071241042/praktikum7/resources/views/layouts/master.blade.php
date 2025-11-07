<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explor Bromo - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root{
            --color-base: #4E499E;   /* aksen utama */
            --color-text: #042440;   /* teks utama yang kamu minta */
            --color-card: #B793C9;   /* card bg (opsional) */
            --color-soft: #A2BEDC;
            --color-accent: #D26B9D;
        }

        /* Hero background */
        .hero-bg {
            background:
                linear-gradient(rgba(78, 73, 158, 0.8), rgba(78, 73, 158, 0.8)),
                url('/images/galeri/bromo-hero.jpg');
            background-size: cover;
            background-position: center;
        }

        /* default text color untuk seluruh dokumen (kecuali yang di-override oleh kelas) */
        body {
            font-family: 'Inter', sans-serif;
            color: var(--color-text);
        }

        /* helper class bila perlu dipanggil eksplisit */
        .text-main { color: var(--color-text) !important; }
        .text-basecolor { color: var(--color-base) !important; }
        .bg-cardcolor { background-color: var(--color-card) !important; }

        /* jika ada teks di dalam hero yang perlu putih, gunakan .hero-white (atau biarkan kelas Tailwind text-white) */
        .hero-white { color: #ffffff; }

        /* kecil: pastikan links di nav tidak inherit warna body ketika harus tetap putih */
        header.hero-bg a { color: inherit; } /* default: inherit hero text color */
    </style>
</head>

<body class="bg-[#A2BEDC]/20">

    <!-- Header -->
    <!-- Catatan: header punya class hero-bg; default text di dalam header sebaiknya putih agar kontras dengan gambar.
         Gunakan kelas .hero-white pada elemen yang ingin dipaksa putih; elemen lain di luar header tetap #042440. -->
    <header class="hero-bg shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="hero-white">
                    <h1 class="text-3xl font-bold">Explor Bromo</h1>
                    <p class="text-sm opacity-90">Keindahan Gunung Bromo & Sekitarnya</p>
                </div>

                <!-- Navigation -->
                <nav>
                    <ul class="flex space-x-6 hero-white">
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                        <x-nav-link href="/destinasi" :active="request()->is('destinasi')">Destinasi</x-nav-link>
                        <x-nav-link href="/kuliner" :active="request()->is('kuliner')">Kuliner</x-nav-link>
                        <x-nav-link href="/galeri" :active="request()->is('galeri')">Galeri</x-nav-link>
                        <x-nav-link href="/kontak" :active="request()->is('kontak')">Kontak</x-nav-link>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[var(--color-base)] text-white py-6 mt-12 shadow-inner">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 <span class="text-[#B793C9] font-semibold">Explor Bromo</span>. All rights reserved.</p>
            <p class="text-sm opacity-80 mt-2 text-[#A2BEDC]">Discover the Magic of Bromo</p>
        </div>
    </footer>

</body>
</html>
