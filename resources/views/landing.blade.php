@extends('layout')

@section('title', 'UP2D Pasundan - All Tools One Website')
@section('bodyClass', 'bg-[#F3F7FF]')

@section('content')
    <section class="hero-bg px-4" style="
        background-image: url('{{ asset('assets/image/Frame Foto Hero.png') }}');
        background-size: cover; background-position: center bottom; background-repeat: no-repeat;
        position: relative; min-height: 130vh; display: flex; align-items: flex-start;
        padding-top: 2rem; padding-bottom: 4rem;">
        <div class="container mx-auto text-center">
            <h1 class="font-serif-title text-5xl md:text-7xl font-bold text-[#002837] mb-6">
                All Tools<br>One Website
            </h1>
            <p class="text-gray-700 text-lg md:text-xl max-w-2xl mx-auto mb-8">
                Temukan, pantau, dan ajukan peminjaman alat listrik. Semua bisa dilakukan secara online dan efisien.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('form') }}" class="bg-white border-2 border-[#002837] text-[#002837] px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                    Isi Form
                </a>
                <a href="{{ route('layanan') }}" class="bg-[#002837] text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    Our Service
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="bg-white rounded-lg border border-gray-300 shadow-md overflow-hidden">
                <div class="grid md:grid-cols-3">
                    <div class="bg-white p-8 border-r border-gray-200 last:border-r-0">
                        <div class="mb-6 h-40 flex items-center justify-center">
                            <img src="{{ asset('assets/image/Icon UPS.png') }}" alt="Unit Power Supply" class="max-w-full max-h-full object-contain">
                        </div>
                        <h3 class="text-xl font-bold text-[#002837] mb-4">Unit Power Supply</h3>
                        <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                            UPS berfungsi sebagai sumber daya cadangan yang otomatis aktif saat terjadi pemadaman listrik. Alat ini memastikan kontinuitas pasokan listrik untuk peralatan kritis.
                        </p>
                        <a href="#" class="inline-flex items-center bg-[#002837] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Read More
                        </a>
                    </div>
                    <div class="bg-white p-8 border-r border-gray-200 last:border-r-0">
                        <div class="mb-6 h-40 flex items-center justify-center">
                            <img src="{{ asset('assets/image/Icon Load Control.png') }}" alt="Load Control" class="max-w-full max-h-full object-contain">
                        </div>
                        <h3 class="text-xl font-bold text-[#002837] mb-4">Load Control</h3>
                        <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                            UKB digunakan untuk mengatur, memantau, dan menyeimbangkan distribusi beban daya listrik. Dengan alat ini, sistem distribusi menjadi lebih stabil dan efisien.
                        </p>
                        <a href="#" class="inline-flex items-center bg-[#002837] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Read More
                        </a>
                    </div>
                    <div class="bg-white p-8 border-r border-gray-200 last:border-r-0">
                        <div class="mb-6 h-40 flex items-center justify-center">
                            <img src="{{ asset('assets/image/Icon Detection.png') }}" alt="Detection" class="max-w-full max-h-full object-contain">
                        </div>
                        <h3 class="text-xl font-bold text-[#002837] mb-4">Detection</h3>
                        <p class="text-gray-500 text-sm mb-6 leading-relaxed">
                            Alat deteksi berperan dalam memantau kondisi kelistrikan secara real-time untuk menemukan gangguan atau masalah pada sistem distribusi listrik.
                        </p>
                        <a href="#" class="inline-flex items-center bg-[#002837] text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-800 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 px-4">
        <div class="container mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="bg-gray-100 rounded-lg h-64 md:h-96 flex items-center justify-center">
                    <div class="text-[#002837] text-4xl font-bold">UP2D</div>
                </div>
                <div>
                    <p class="text-[#002837] text-sm mb-2">About Us</p>
                    <h2 class="text-4xl md:text-5xl font-bold text-[#002837] mb-6">PLN UP2D JABAR</h2>
                    <p class="text-gray-700 leading-relaxed">
                        PLN UP2D Jawa Barat merupakan unit di bawah PLN UID Jawa Barat yang berperan sebagai pusat kendali distribusi listrik. UP2D bertugas mengatur, memantau, dan mengendalikan sistem distribusi tenaga listrik agar penyaluran ke pelanggan tetap andal, stabil, dan efisien. Secara singkat, UP2D memastikan listrik dari gardu induk tersalurkan ke pelanggan dengan aman dan tanpa gangguan.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
