<footer class="footer bg-gray-800/95 text-white py-8 backdrop-blur-lg">
    <div class="footer-content max-w-6xl mx-auto px-5 grid grid-cols-1 md:grid-cols-3 gap-8 mb-6">
        <!-- Company Info -->
        <div class="footer-section">
            <h3 class="text-lg font-bold mb-4">Jayapura Explorer</h3>
            <p class="text-gray-300 text-sm leading-relaxed mb-4">
                Menjelajahi keindahan dan kekayaan budaya Kota Jayapura, Papua. 
                Temukan pesona alam, kuliner autentik, dan pengalaman tak terlupakan.
            </p>
            <div class="social-links flex gap-3">
                <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-white hover:bg-red-500 transition-colors">
                    <i class="fab fa-instagram text-sm"></i>
                </a>
                <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-white hover:bg-red-500 transition-colors">
                    <i class="fab fa-facebook text-sm"></i>
                </a>
                <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-white hover:bg-red-500 transition-colors">
                    <i class="fab fa-twitter text-sm"></i>
                </a>
                <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-white hover:bg-red-500 transition-colors">
                    <i class="fab fa-youtube text-sm"></i>
                </a>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="footer-section">
            <h4 class="font-semibold mb-4">Quick Links</h4>
            <ul class="space-y-2">
                <li>
                    <a href="{{ url('/') }}" class="text-gray-300 hover:text-white text-sm transition-colors">Home</a>
                </li>
                <li>
                    <a href="{{ url('/destinasi') }}" class="text-gray-300 hover:text-white text-sm transition-colors">Destinasi</a>
                </li>
                <li>
                    <a href="{{ url('/kuliner') }}" class="text-gray-300 hover:text-white text-sm transition-colors">Kuliner</a>
                </li>
                <li>
                    <a href="{{ url('/galeri') }}" class="text-gray-300 hover:text-white text-sm transition-colors">Galeri</a>
                </li>
                <li>
                    <a href="{{ url('/kontak') }}" class="text-gray-300 hover:text-white text-sm transition-colors">Kontak</a>
                </li>
            </ul>
        </div>
        
        <!-- Contact Info -->
        <div class="footer-section">
            <h4 class="font-semibold mb-4">Kontak Kami</h4>
            <div class="space-y-2 text-sm text-gray-300">
                <p class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-red-400"></i>
                    <span>Jayapura, Papua, Indonesia</span>
                </p>
                <p class="flex items-center gap-2">
                    <i class="fas fa-phone text-red-400"></i>
                    <span>+62 821 9824xxx</span>
                </p>
                <p class="flex items-center gap-2">
                    <i class="fas fa-envelope text-red-400"></i>
                    <span>info@jayapuraexplorer.com</span>
                </p>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom border-t border-gray-700 pt-6">
        <p class="text-center text-gray-400 text-xs">
            &copy; 2024 Jayapura Explorer. All rights reserved. | 
            Developed with <i class="fas fa-heart text-red-400 mx-1"></i> for Papua Tourism
        </p>
    </div>
</footer>