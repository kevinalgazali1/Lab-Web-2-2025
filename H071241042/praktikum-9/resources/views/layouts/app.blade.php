<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Product Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand totoro-float" href="{{ url('/') }}">
                <i class="fas fa-dragon"></i>
                Product Management
            </a>
            <ul class="navbar-nav">
                <li><a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                    <i class="fas fa-leaf me-1"></i>Categories
                </a></li>
                <li><a class="nav-link {{ request()->is('warehouses*') ? 'active' : '' }}" href="{{ route('warehouses.index') }}">
                    <i class="fas fa-mountain me-1"></i>Warehouses
                </a></li>
                <li><a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                    <i class="fas fa-seedling me-1"></i>Products
                </a></li>
                <li><a class="nav-link {{ request()->is('stock*') ? 'active' : '' }}" href="{{ route('stock.index') }}">
                    <i class="fas fa-wind me-1"></i>Stock
                </a></li>
            </ul>
        </div>
    </nav>

    <div class="container main-container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="text-center">
        <div class="container">
            <p class="mb-0">
                2025 - All rights reserved
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });
    </script>
</body>
</html>