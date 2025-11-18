<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Sistem Manajemen Produk</title>
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
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Edit Produk</h1>
                        <p class="text-gray-600">Edit data produk: {{ $produk->nama }}</p>
                    </div>
                    <a href="{{ route('produks.index') }}" class="text-gray-500 hover:text-gray-700 transition duration-200">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <form action="{{ route('produks.update', $produk) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Dasar -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Dasar</h3>
                            
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
                                <input type="text" name="nama" id="nama" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       value="{{ old('nama', $produk->nama) }}"
                                       placeholder="Masukkan nama produk">
                                @error('nama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga *</label>
                                <input type="number" name="harga" id="harga" required min="0" step="0.01"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       value="{{ old('harga', $produk->harga) }}"
                                       placeholder="Masukkan harga">
                                @error('harga')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select name="kategori_id" id="kategori_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Detail Produk -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Detail Produk</h3>
                            
                            <div>
                                <label for="berat" class="block text-sm font-medium text-gray-700 mb-1">Berat (kg) *</label>
                                <input type="number" name="berat" id="berat" required min="0" step="0.01"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       value="{{ old('berat', $produk->detailProduk->berat ?? '') }}"
                                       placeholder="Masukkan berat dalam kg">
                                @error('berat')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ukuran" class="block text-sm font-medium text-gray-700 mb-1">Ukuran</label>
                                <input type="text" name="ukuran" id="ukuran"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       value="{{ old('ukuran', $produk->detailProduk->ukuran ?? '') }}"
                                       placeholder="Contoh: 15 inch, M, 42">
                                @error('ukuran')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Masukkan deskripsi produk">{{ old('deskripsi', $produk->detailProduk->deskripsi ?? '') }}</textarea>
                                @error('deskripsi')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 mt-6 border-t">
                        <a href="{{ route('produks.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                            <i class="fas fa-save mr-2"></i>Perbarui Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>