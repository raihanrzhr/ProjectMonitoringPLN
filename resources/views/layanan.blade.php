@extends('layout')

@section('title', 'Layanan Pengadaan Alat Listrik - UP2D Pasundan')
@section('bodyClass', 'bg-white')

@section('content')
    <section class="relative min-h-[480px] md:min-h-[540px] flex items-center justify-center bg-cover bg-center"
        style="background-image: url('{{ asset('assets/image/Foto Hero .png') }}');">
        <div class="absolute inset-0 bg-blue-900 bg-opacity-50"></div>
        <div class="relative z-10 w-full">
            <div class="container mx-auto flex flex-col items-center justify-center text-center h-full px-4 py-16">
                <nav class="mb-6 flex items-center justify-center space-x-2 text-white text-sm font-medium">
                    <a href="{{ route('landing') }}" class="hover:underline hover:text-yellow-400 transition">
                        Home
                    </a>
                    <span class="mx-1 text-white/80 font-bold">/</span>
                    <span class="text-yellow-400 cursor-default">Services</span>
                </nav>
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg leading-tight">
                    Layanan Pengadaan <br>
                    <span class="text-yellow-400">Alat Listrik</span>
                </h1>
                <p class="text-white text-lg md:text-xl max-w-2xl mx-auto drop-shadow-md">
                    Jelajahi berbagai layanan pengadaan alat listrik yang membantu operasional distribusi PLN lebih efisien.
                </p>
            </div>
        </div>
    </section>

    <section class="py-20 px-4">
        <div class="container mx-auto">
            <div class="bg-blue-900 rounded-2xl p-6 md:p-12">
                <div class="flex flex-wrap gap-2 mb-8 border-b border-blue-800 justify-center items-center">
                    <button class="px-6 py-3 bg-white text-blue-900 rounded-full active-tab mb-[-6px]" style="margin-bottom:-6px; position:relative; z-index:1;" data-tab="jenis">
                        Jenis Alat
                    </button>
                    <button class="px-6 py-3 text-blue-300 hover:text-white transition rounded-full mb-[-6px]" style="margin-bottom:-6px; position:relative; z-index:1;" data-tab="cara">
                        Cara Kerja Layanan
                    </button>
                </div>

                <!-- Jenis Alat Content -->
                <div id="jenisContent" class="grid md:grid-cols-3 gap-8">
                    <!-- UPS Card -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow flex flex-col items-center relative">
                        <div class="w-full h-40 relative flex justify-center">
                            <img src="{{ asset('assets/image/Frame Gambar-1.png') }}" alt="UPS" class="w-full h-full object-cover">
                            <div class="absolute left-1/2 -bottom-8 transform -translate-x-1/2 z-20">
                                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                    <i class="fa-solid fa-bolt text-white text-3xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pt-12 px-6 pb-6 flex-1 flex flex-col justify-end items-center text-center">
                            <h3 class="text-lg font-bold text-blue-900 mb-2">Uninterruptible Power Supply</h3>
                            <p class="text-gray-600 text-sm">Alat cadangan daya yang menjaga sistem tetap aktif saat pemadaman, memastikan peralatan penting PLN seperti SCADA dan kontrol distribusi terus berfungsi tanpa gangguan.</p>
                        </div>
                    </div>
                    <!-- UKB Card -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow flex flex-col items-center relative">
                        <div class="w-full h-40 relative flex justify-center">
                            <img src="{{ asset('assets/image/Frame Gambar-2.png') }}" alt="UKB" class="w-full h-full object-cover">
                            <div class="absolute left-1/2 -bottom-8 transform -translate-x-1/2 z-20">
                                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                    <i class="fa-solid fa-plug text-white text-3xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pt-12 px-6 pb-6 flex-1 flex flex-col justify-end items-center text-center">
                            <h3 class="text-lg font-bold text-blue-900 mb-2">Unit Kabel Bergerak (UKB)</h3>
                            <p class="text-gray-600 text-sm">Peralatan untuk distribusi listrik sementara saat perawatan atau gangguan, membantu menjaga pasokan listrik tetap berjalan dan mempercepat normalisasi jaringan.</p>
                        </div>
                    </div>
                    <!-- Deteksi Card -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow flex flex-col items-center relative">
                        <div class="w-full h-40 relative flex justify-center">
                            <img src="{{ asset('assets/image/Frame Gambar-3.png') }}" alt="Deteksi" class="w-full h-full object-cover">
                            <div class="absolute left-1/2 -bottom-8 transform -translate-x-1/2 z-20">
                                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                    <i class="fa-solid fa-magnifying-glass text-white text-3xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pt-12 px-6 pb-6 flex-1 flex flex-col justify-end items-center text-center">
                            <h3 class="text-lg font-bold text-blue-900 mb-2">Deteksi</h3>
                            <p class="text-gray-600 text-sm">Sistem yang mendeteksi gangguan jaringan listrik, seperti korsleting atau anomali beban, melalui sensor dan sistem monitoring seperti SCADA dan FMS.</p>
                        </div>
                    </div>
                </div>

                <!-- Cara Kerja Layanan Content -->
                <div id="caraContent" class="grid md:grid-cols-4 gap-8" style="display: none;">
                    <!-- Cari Alat -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow flex flex-col items-center relative">
                        <div class="w-full h-40 relative flex justify-center">
                            <img src="{{ asset('assets/image/Frame Gambar-4.png') }}" alt="Cari Alat" class="w-full h-full object-cover">
                            <div class="absolute left-1/2 -bottom-8 transform -translate-x-1/2 z-20">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                    <i class="fa-solid fa-wrench text-blue-900 text-3xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pt-12 px-6 pb-6 flex-1 flex flex-col justify-end items-center text-center">
                            <h3 class="text-lg font-bold text-blue-900 mb-2">Cari Alat</h3>
                            <p class="text-gray-600 text-sm">Jelajahi daftar alat listrik yang tersedia sesuai kebutuhan Anda melalui website dengan mudah dan cepat.</p>
                        </div>
                    </div>
                    <!-- Isi Formulir -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow flex flex-col items-center relative">
                        <div class="w-full h-40 relative flex justify-center">
                            <img src="{{ asset('assets/image/Frame Gambar-5.png') }}" alt="Isi Formulir" class="w-full h-full object-cover">
                            <div class="absolute left-1/2 -bottom-8 transform -translate-x-1/2 z-20">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                    <i class="fa-solid fa-file-lines text-blue-900 text-3xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pt-12 px-6 pb-6 flex-1 flex flex-col justify-end items-center text-center">
                            <h3 class="text-lg font-bold text-blue-900 mb-2">Isi Formulir</h3>
                            <p class="text-gray-600 text-sm">Masukkan informasi diri dan detail kebutuhan alat agar proses peminjaman dapat diproses dengan tepat.</p>
                        </div>
                    </div>
                    <!-- Verifikasi oleh Admin -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow flex flex-col items-center relative">
                        <div class="w-full h-40 relative flex justify-center">
                            <img src="{{ asset('assets/image/Frame Gambar-6.png') }}" alt="Verifikasi" class="w-full h-full object-cover">
                            <div class="absolute left-1/2 -bottom-8 transform -translate-x-1/2 z-20">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                    <i class="fa-solid fa-check text-blue-900 text-3xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pt-12 px-6 pb-6 flex-1 flex flex-col justify-end items-center text-center">
                            <h3 class="text-lg font-bold text-blue-900 mb-2">Verifikasi oleh Admin</h3>
                            <p class="text-gray-600 text-sm">Admin akan memeriksa dan mengonfirmasi ketersediaan alat sesuai dengan pengajuan Anda.</p>
                        </div>
                    </div>
                    <!-- Ambil & Gunakan Alat -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow flex flex-col items-center relative">
                        <div class="w-full h-40 relative flex justify-center">
                            <img src="{{ asset('assets/image/Frame Gambar.png') }}" alt="Ambil Alat" class="w-full h-full object-cover">
                            <div class="absolute left-1/2 -bottom-8 transform -translate-x-1/2 z-20">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                    <i class="fa-solid fa-truck text-blue-900 text-3xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pt-12 px-6 pb-6 flex-1 flex flex-col justify-end items-center text-center">
                            <h3 class="text-lg font-bold text-blue-900 mb-2">Ambil & Gunakan Alat</h3>
                            <p class="text-gray-600 text-sm">Setelah disetujui, alat dapat diambil dan digunakan untuk mendukung operasional lapangan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 px-4 bg-blue-100">
        <div class="container mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="flex justify-center items-end h-full">
                    <div class="w-full h-full flex items-end">
                        <img
                            src="{{ asset('assets/image/Frame CTA Ilustrasi.png') }}"
                            alt="Ilustrasi Ajukan Alat"
                            class="w-96 h-96 object-contain mx-auto block"
                            style="margin-bottom:0;display:block;"
                        />
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-6">
                        Sudah menemukan alat yang Anda butuhkan?
                    </h2>
                    <a href="{{ route('form') }}" class="inline-flex items-center bg-blue-900 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-800 transition">
                        Isi Formulir
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('[data-tab]');
    const jenisContent = document.getElementById('jenisContent');
    const caraContent = document.getElementById('caraContent');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabType = tab.getAttribute('data-tab');

            // Update tab styles
            tabs.forEach(t => {
                t.classList.remove('bg-white', 'text-blue-900', 'active-tab');
                t.classList.add('text-blue-300');
            });
            tab.classList.add('bg-white', 'text-blue-900', 'active-tab');
            tab.classList.remove('text-blue-300');

            // Show/hide content
            if (tabType === 'jenis') {
                jenisContent.style.display = 'grid';
                caraContent.style.display = 'none';
            } else if (tabType === 'cara') {
                jenisContent.style.display = 'none';
                caraContent.style.display = 'grid';
            } else {
                jenisContent.style.display = 'grid';
                caraContent.style.display = 'none';
            }
        });
    });
});
</script>
@endpush

