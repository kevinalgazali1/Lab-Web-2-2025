<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Product Management')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="bg-gray-100 text-gray-800">

    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('categories.index') }}" class="text-xl font-bold text-blue-600">Manajemen Produk</a>
            <div>
                <a href="{{ route('categories.index') }}"
                    class="{{ request()->routeIs('categories.*') ? 'text-blue-600 font-bold' : 'text-gray-600' }} hover:text-blue-600 px-3 py-2 rounded-md">
                    Kategori
                </a>

                <a href="{{ route('warehouses.index') }}"
                    class="{{ request()->routeIs('warehouses.*') ? 'text-blue-600 font-bold' : 'text-gray-600' }} hover:text-blue-600 px-3 py-2 rounded-md">
                    Gudang
                </a>

                <a href="{{ route('products.index') }}"
                    class="{{ request()->routeIs('products.*') ? 'text-blue-600 font-bold' : 'text-gray-600' }} hover:text-blue-600 px-3 py-2 rounded-md">
                    Produk
                </a>

                <a href="{{ route('stocks.index') }}"
                    class="{{ request()->routeIs('stocks.*') ? 'text-blue-600 font-bold' : 'text-gray-600' }} hover:text-blue-600 px-3 py-2 rounded-md">
                    Manajemen Stok
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div id="flash-data" style="display:none"
        data-success="{{ e(session('success')) }}"
        data-error="{{ e(session('error')) }}"
        data-errors='{{ $errors->any() ? json_encode($errors->all()) : "" }}'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var flash = document.getElementById('flash-data');
            if (!flash) return;

            var success = flash.getAttribute('data-success');
            var error = flash.getAttribute('data-error');
            var errors = flash.getAttribute('data-errors');

            try {
                errors = errors ? JSON.parse(errors) : [];
            } catch (e) {
                errors = [];
            }

            if (success) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: success,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }

            if (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error,
                    confirmButtonColor: '#3085d6'
                });
            }

            if (errors && errors.length) {
                var html = '<div class="text-left"><p>Silakan perbaiki kesalahan berikut:</p><ul class="list-disc list-inside">';
                errors.forEach(function(e) {
                    html += '<li>' + e + '</li>';
                });
                html += '</ul></div>';

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: html,
                    confirmButtonColor: '#3085d6'
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>