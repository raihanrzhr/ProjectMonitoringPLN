<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
        <div class="flex items-center">
            <img
                src="{{ asset('assets/image/Logo.png') }}"
                alt="UP2D Pasundan Logo"
                class="w-30 h-30 object-contain"
            />
        </div>
        <div class="hidden md:flex space-x-6">
            <a href="{{ route('landing') }}" class="text-blue-900 font-medium hover:text-blue-700">Home</a>
            <a href="{{ route('layanan') }}" class="text-gray-600 hover:text-blue-900">Services</a>
            <a href="{{ route('form') }}" class="text-gray-600 hover:text-blue-900">Form</a>
            <a href="#contact" class="text-gray-600 hover:text-blue-900">Contact</a>
        </div>
        <a href="{{ route('login') }}" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition">
            Login
        </a>
        <button class="md:hidden text-blue-900" id="mobileMenuBtn" aria-label="Toggle menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </nav>
    <div class="hidden md:hidden bg-white border-t" id="mobileMenu">
        <div class="container mx-auto px-4 py-4 space-y-3">
            <a href="{{ route('landing') }}" class="block text-blue-900 font-medium">Home</a>
            <a href="{{ route('layanan') }}" class="block text-gray-600 hover:text-blue-900">Services</a>
            <a href="{{ route('form') }}" class="block text-gray-600 hover:text-blue-900">Form</a>
            <a href="#contact" class="block text-gray-600 hover:text-blue-900">Contact</a>
        </div>
    </div>
</header>

