<nav class="navbar fixed top-0 w-full glass-effect py-3 z-50 shadow-lg">
    <div class="nav-container max-w-7xl mx-auto px-5 flex justify-between items-center">
        <div class="nav-logo flex items-center gap-3">
            <div class="relative">
                <img src="/image/logo-jayapura.png" alt="Logo Jayapura" class="w-10 h-10 rounded-full object-cover border-2 border-white/30 shadow-lg">
                <div class="absolute -inset-1 bg-gradient-to-r from-primary-400 to-accent-500 rounded-full blur opacity-30"></div>
            </div>
            <span class="text-xl font-bold gradient-text">Jayapura Explorer</span>
        </div>
        
        <ul class="nav-menu hidden md:flex list-none gap-8">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link text-white/90 hover:text-white font-medium text-sm transition-all duration-300 relative group {{ request()->is('/') ? 'text-white' : '' }}">
                    <i class="fas fa-home mr-2"></i>Home
                    <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-primary-400 to-accent-500 transition-all duration-300 group-hover:w-full {{ request()->is('/') ? 'w-full' : '' }}"></div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/destinasi') }}" class="nav-link text-white/90 hover:text-white font-medium text-sm transition-all duration-300 relative group {{ request()->is('destinasi') ? 'text-white' : '' }}">
                    <i class="fas fa-map-marked-alt mr-2"></i>Destinasi
                    <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-primary-400 to-accent-500 transition-all duration-300 group-hover:w-full {{ request()->is('destinasi') ? 'w-full' : '' }}"></div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/kuliner') }}" class="nav-link text-white/90 hover:text-white font-medium text-sm transition-all duration-300 relative group {{ request()->is('kuliner') ? 'text-white' : '' }}">
                    <i class="fas fa-utensils mr-2"></i>Kuliner
                    <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-primary-400 to-accent-500 transition-all duration-300 group-hover:w-full {{ request()->is('kuliner') ? 'w-full' : '' }}"></div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/galeri') }}" class="nav-link text-white/90 hover:text-white font-medium text-sm transition-all duration-300 relative group {{ request()->is('galeri') ? 'text-white' : '' }}">
                    <i class="fas fa-images mr-2"></i>Galeri
                    <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-primary-400 to-accent-500 transition-all duration-300 group-hover:w-full {{ request()->is('galeri') ? 'w-full' : '' }}"></div>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/kontak') }}" class="nav-link text-white/90 hover:text-white font-medium text-sm transition-all duration-300 relative group {{ request()->is('kontak') ? 'text-white' : '' }}">
                    <i class="fas fa-envelope mr-2"></i>Kontak
                    <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-primary-400 to-accent-500 transition-all duration-300 group-hover:w-full {{ request()->is('kontak') ? 'w-full' : '' }}"></div>
                </a>
            </li>
        </ul>
        
        <div class="hamburger md:hidden flex flex-col cursor-pointer w-6 h-5 relative">
            <span class="bar w-full h-0.5 bg-white mb-1.5 transition-all rounded-full"></span>
            <span class="bar w-full h-0.5 bg-white mb-1.5 transition-all rounded-full"></span>
            <span class="bar w-full h-0.5 bg-white transition-all rounded-full"></span>
        </div>
    </div>
</nav>

<style>
    .nav-menu.active {
        left: 0 !important;
    }
    
    @media (max-width: 768px) {
        .nav-menu {
            position: fixed;
            left: -100%;
            top: 70px;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            width: 100%;
            text-align: center;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem 0;
            gap: 0;
        }
        
        .nav-item {
            margin: 0.8rem 0;
        }
        
        .nav-link {
            color: #4b5563 !important;
            font-size: 1.1rem !important;
            padding: 0.8rem 2rem !important;
        }
        
        .nav-link:hover {
            color: #667eea !important;
        }
        
        .hamburger.active .bar:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
            background: #667eea;
        }
        
        .hamburger.active .bar:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.active .bar:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
            background: #667eea;
        }
    }
    
    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>