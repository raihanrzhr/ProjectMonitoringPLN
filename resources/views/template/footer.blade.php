<footer class="bg-blue-900 text-white py-12 px-4" id="contact">
    <div class="container mx-auto">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">

                    <div>
                        <img
                        src="{{ asset('assets/image/Frame Logo Footer.png') }}"
                        alt="UP2D Pasundan Logo"
                        class="w-50 h-50 object-contain"
                    />
                    </div>
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

