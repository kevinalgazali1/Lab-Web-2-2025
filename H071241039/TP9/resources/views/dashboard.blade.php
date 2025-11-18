<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Manajemen Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ url('/') }}" class="text-xl font-bold">
                    <i class="fas fa-boxes mr-2"></i>Manajemen Produk
                </a>
                <div class="space-x-4">
                    <a href="{{ route('kategoris.index') }}" class="hover:text-blue-200 transition duration-200">
                        <i class="fas fa-tags mr-1"></i>Kategori
                    </a>
                    <a href="{{ route('gudangs.index') }}" class="hover:text-blue-200 transition duration-200">
                        <i class="fas fa-warehouse mr-1"></i>Gudang
                    </a>
                    <a href="{{ route('produks.index') }}" class="hover:text-blue-200 transition duration-200">
                        <i class="fas fa-box mr-1"></i>Produk
                    </a>
                    <a href="{{ route('stoks.index') }}" class="hover:text-blue-200 transition duration-200">
                        <i class="fas fa-exchange-alt mr-1"></i>Stok
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600">Selamat datang di Sistem Manajemen Produk</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-box text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Produk</h3>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Produk::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-tags text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Kategori</h3>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Kategori::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-warehouse text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Gudang</h3>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Gudang::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-exchange-alt text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Total Stok</h3>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\StokGudang::sum('kuantitas') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>