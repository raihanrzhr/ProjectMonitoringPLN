<footer class="bg-blue-900 text-white py-12 px-4" id="contact">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">

                    <div>
                        <img
                        src="{{ asset('assets/image/Frame Logo Footer.png') }}"
                        alt="UP2D Pasundan Logo"
                        class="w-30 h-30 object-contain"
                    />
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="#" class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <span class="text-white font-bold">f</span>
                    </a>
                    <a href="#" class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4 border-b-2 border-blue-700 pb-2 inline-block">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('landing') }}" class="hover:text-yellow-400 transition">Home</a></li>
                    <li><a href="{{ route('layanan') }}" class="hover:text-yellow-400 transition">Services</a></li>
                    <li><a href="{{ route('form') }}" class="hover:text-yellow-400 transition">Form</a></li>
                    <li><a href="#contact" class="hover:text-yellow-400 transition">Contacts</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4 border-b-2 border-blue-700 pb-2 inline-block">Contacts</h3>
                <ul class="space-y-3">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>08***********</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Jl. Gegerkalong, Bandung, Jawa Barat</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>plnup2d@gmail.com</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-blue-800 pt-8 text-center text-sm">
            © Copyright 2025 UP2D Pasundan
        </div>
    </div>
</footer>

