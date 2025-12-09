<header id="siteHeader"
    class="{{ request()->routeIs('landing') ? 'bg-transparent' : 'bg-white shadow-sm' }} sticky top-0 z-50 transition-colors duration-300">
    <nav class="container mx-auto px-4 py-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="/">
                <img src="{{ asset('assets/image/Logo.png') }}" alt="UP2D Pasundan Logo"
                    class="h-8 w-auto object-contain" />
            </a>
        </div>
        <div class="hidden md:flex space-x-6">
            <a href="{{ route('landing') }}"
                class="{{ request()->routeIs('landing') ? 'text-[#002837] font-medium' : 'text-gray-600' }} hover:text-[#002837]">Home</a>
            <a href="{{ route('layanan') }}"
                class="{{ request()->routeIs('layanan') ? 'text-[#002837] font-medium' : 'text-gray-600' }} hover:text-[#002837]">Services</a>
            <a href="{{ route('form') }}"
                class="{{ request()->routeIs('form') ? 'text-[#002837] font-medium' : 'text-gray-600' }} hover:text-[#002837]">Form</a>
            <a href="#contact" class="text-gray-600 hover:text-[#002837]">Contact</a>
        </div>
        <a href="{{ route('login') }}"
            class="bg-[#002837] text-white px-4 py-1.5 rounded-lg text-sm hover:bg-blue-800 transition">
            Login
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                style="background-color: red; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
                Logout
            </button>
        </form>
        <button class="md:hidden text-[#002837]" id="mobileMenuBtn" aria-label="Toggle menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>
    <div class="hidden md:hidden bg-white border-t" id="mobileMenu">
        <div class="container mx-auto px-4 py-4 space-y-3">
            <a href="{{ route('landing') }}" class="block text-[#002837] font-medium">Home</a>
            <a href="{{ route('layanan') }}" class="block text-gray-600 hover:text-[#002837]">Services</a>
            <a href="{{ route('form') }}" class="block text-gray-600 hover:text-[#002837]">Form</a>
            <a href="#contact" class="block text-gray-600 hover:text-[#002837]">Contact</a>
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