<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok - Sistem Manajemen Produk</title>
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
        @if(session('sukses'))
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('sukses') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg mb-6 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Stok</h1>
                <p class="text-gray-600">Kelola stok produk di gudang</p>
            </div>
            <a href="{{ route('stoks.transfer') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-exchange-alt mr-2"></i> Transfer Stok
            </a>
        </div>

        <!-- Filter Gudang -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('stoks.index') }}">
                <div class="flex items-end space-x-4">
                    <div class="flex-1">
                        <label for="gudang_id" class="block text-sm font-medium text-gray-700 mb-1">Filter Berdasarkan Gudang</label>
                        <select name="gudang_id" id="gudang_id" onchange="this.form.submit()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Gudang</option>
                            @foreach($gudangs as $gudang)
                            <option value="{{ $gudang->id }}" {{ $gudangTerpilih == $gudang->id ? 'selected' : '' }}>
                                {{ $gudang->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @if($gudangTerpilih)
                    <a href="{{ route('stoks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Reset Filter
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gudang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($stoks as $stok)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $stok->produk->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $stok->produk->kategori->nama ?? 'Tanpa Kategori' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $stok->gudang->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $stok->gudang->lokasi ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $stok->kuantitas > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $stok->kuantitas }} unit
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($stok->kuantitas > 0)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Tersedia
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Habis
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                <p>Belum ada data stok</p>
                                <a href="{{ route('stoks.transfer') }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                                    Tambah Stok Pertama
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>