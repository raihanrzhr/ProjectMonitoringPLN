<header id="siteHeader"
    class="{{ request()->routeIs('landing') ? 'bg-transparent' : 'bg-white shadow-sm' }} sticky top-0 z-50 transition-colors duration-300">
    <nav class="container mx-auto px-4 py-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="/" class="group flex items-center transition-all duration-300 hover:opacity-80">
                <img src="{{ asset('assets/image/Logo.png') }}" alt="UP2D Pasundan Logo"
                    class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105" />
            </a>
        </div>
        <div class="hidden md:flex items-center space-x-1">
            <a href="{{ route('landing') }}"
                class="group flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-300 {{ request()->routeIs('landing') ? 'bg-[#002837]/10 text-[#002837] font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('landing') ? 'text-[#002837]' : 'text-gray-400 group-hover:text-[#002837]' }} transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="group-hover:text-[#002837] transition-colors">Home</span>
            </a>
            <a href="{{ route('layanan') }}"
                class="group flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-300 {{ request()->routeIs('layanan') ? 'bg-[#002837]/10 text-[#002837] font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('layanan') ? 'text-[#002837]' : 'text-gray-400 group-hover:text-[#002837]' }} transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span class="group-hover:text-[#002837] transition-colors">Services</span>
            </a>
            <a href="{{ route('form') }}"
                class="group flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-300 {{ request()->routeIs('form') ? 'bg-[#002837]/10 text-[#002837] font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('form') ? 'text-[#002837]' : 'text-gray-400 group-hover:text-[#002837]' }} transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="group-hover:text-[#002837] transition-colors">Form</span>
            </a>
            <a href="#contact"
                class="group flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-300 text-gray-600 hover:bg-gray-100">
                <svg class="w-4 h-4 text-gray-400 group-hover:text-[#002837] transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="group-hover:text-[#002837] transition-colors">Contact</span>
            </a>
        </div>
        <div class="flex items-center gap-3">
            @guest
                <a href="{{ route('login') }}"
                    class="bg-[#002837] text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-800 transition-all duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
            @endguest
            @auth
                <span class="text-gray-600 text-sm hidden sm:inline">Halo, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-red-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            @endauth
        </div>
        <button class="md:hidden text-[#002837]" id="mobileMenuBtn" aria-label="Toggle menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>
    <div class="hidden md:hidden bg-white border-t shadow-lg" id="mobileMenu">
        <div class="container mx-auto px-4 py-4 space-y-2">
            <a href="{{ route('landing') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('landing') ? 'bg-[#002837]/10 text-[#002837] font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>
            <a href="{{ route('layanan') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('layanan') ? 'bg-[#002837]/10 text-[#002837] font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Services
            </a>
            <a href="{{ route('form') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 {{ request()->routeIs('form') ? 'bg-[#002837]/10 text-[#002837] font-semibold' : 'text-gray-600 hover:bg-gray-100' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Form
            </a>
            <a href="#contact"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 text-gray-600 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Contact
            </a>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var header = document.getElementById('siteHeader');
        if (!header) return;
        var isLanding = {{ request()->routeIs('landing') ? 'true' : 'false' }};
        if (!isLanding) return;
        function onScroll() {
            if (window.scrollY > 10) {
                header.classList.add('bg-white', 'shadow-sm');
                header.classList.remove('bg-transparent');
            } else {
                header.classList.add('bg-transparent');
                header.classList.remove('bg-white', 'shadow-sm');
            }
        }
        onScroll();
        window.addEventListener('scroll', onScroll);
    });
</script>