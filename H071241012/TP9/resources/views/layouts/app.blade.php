<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    {{-- Navbar atau Header --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Manajemen Produk</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('warehouses.index') }}">Gudang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('stocks.index') }}">Stok</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        {{-- INI ADALAH TEMPAT KONTEN DARI @section('content') DIMUAT --}}
        @yield('content') 
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>