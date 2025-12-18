<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UP2D Pasundan')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/LOGO_PLN_1.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/LOGO_PLN_1.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/LOGO_PLN_1.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap');
        .font-serif-title {
            font-family: 'Playfair Display', serif;
        }
    </style>
    @stack('styles')
</head>
<body class="@yield('bodyClass', 'bg-white')">
    @include('template.navbar')

    <main>
        @yield('content')
    </main>

    @include('template.footer')

    <script>
        // Toggle mobile menu (digunakan global oleh semua halaman)
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

