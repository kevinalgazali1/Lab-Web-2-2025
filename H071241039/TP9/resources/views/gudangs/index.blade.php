<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Gudang - Sistem Manajemen Produk</title>
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

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Gudang</h1>
                <p class="text-gray-600">Kelola gudang penyimpanan produk</p>
            </div>
            <a href="{{ route('gudangs.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-plus mr-2"></i> Tambah Gudang
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Gudang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($gudangs as $gudang)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $gudang->nama }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500">{{ $gudang->lokasi ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('gudangs.edit', $gudang) }}" class="text-green-600 hover:text-green-900 transition duration-200" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('gudangs.destroy', $gudang) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus gudang {{ $gudang->nama }}?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                <i class="fas fa-warehouse text-4xl mb-2 text-gray-300"></i>
                                <p>Belum ada gudang</p>
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