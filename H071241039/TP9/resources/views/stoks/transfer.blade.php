<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Stok - Sistem Manajemen Produk</title>
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

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Transfer Stok</h1>
                        <p class="text-gray-600">Tambah atau kurangi stok produk di gudang</p>
                    </div>
                    <a href="{{ route('stoks.index') }}" class="text-gray-500 hover:text-gray-700 transition duration-200">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <form action="{{ route('stoks.process-transfer') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="gudang_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Gudang *</label>
                            <select name="gudang_id" id="gudang_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Gudang</option>
                                @foreach($gudangs as $gudang)
                                <option value="{{ $gudang->id }}" {{ old('gudang_id') == $gudang->id ? 'selected' : '' }}>
                                    {{ $gudang->nama }} - {{ $gudang->lokasi ?? 'Lokasi tidak tersedia' }}
                                </option>
                                @endforeach
                            </select>
                            @error('gudang_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="produk_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk *</label>
                            <select name="produk_id" id="produk_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Produk</option>
                                @foreach($produks as $produk)
                                <option value="{{ $produk->id }}" {{ old('produk_id') == $produk->id ? 'selected' : '' }}>
                                    {{ $produk->nama }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                            @error('produk_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kuantitas" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok *</label>
                            <input type="number" name="kuantitas" id="kuantitas" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   value="{{ old('kuantitas') }}"
                                   placeholder="Contoh: 10 (tambah) atau -5 (kurangi)">
                            <p class="text-sm text-gray-500 mt-1">
                                Gunakan angka positif untuk menambah stok, angka negatif untuk mengurangi stok
                            </p>
                            @error('kuantitas')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-2 mt-1"></i>
                                <div>
                                    <p class="text-yellow-700 text-sm font-medium mb-1">Perhatian</p>
                                    <p class="text-yellow-600 text-sm">
                                        Stok tidak boleh minus. Jika produk belum ada di gudang, inputan minus akan ditolak.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <a href="{{ route('stoks.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                                <i class="fas fa-exchange-alt mr-2"></i>Proses Transfer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>