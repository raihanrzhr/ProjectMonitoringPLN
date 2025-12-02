@extends('layout')

@section('title', 'Register - UP2D Pasundan')
@section('bodyClass', 'bg-white min-h-screen')

@section('content')
    <main class="container mx-auto px-4 py-12">
        <div class="flex justify-center items-center min-h-[calc(100vh-200px)]">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    <div class="p-8 md:p-12">
                        <h1 class="font-serif-title text-4xl md:text-5xl font-bold text-[#002837] mb-10 text-center">Register</h1>
                        <form class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Nama</label>
                                    <input type="text" class="w-full px-4 py-3 rounded-lg focus:outline-none" style="background-color:#f5f5f5;border:none" placeholder="Enter your name">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">NIP</label>
                                    <input id="nipInput" type="text" class="w-full px-4 py-3 rounded-lg focus:outline-none" style="background-color:#f5f5f5;border:none" placeholder="Masukkan NIP">
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" class="w-full px-4 py-3 rounded-lg focus:outline-none" style="background-color:#f5f5f5;border:none" placeholder="Enter your email">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Password</label>
                                <input type="password" class="w-full px-4 py-3 rounded-lg focus:outline-none" style="background-color:#f5f5f5;border:none" placeholder="Enter your password">
                            </div>
                            <button type="button" onclick="registerHandler()" class="w-full bg-[#002837] text-white py-3 rounded-lg font-serif-title font-bold text-lg hover:bg-blue-800 transition">
                                Register
                            </button>
                        </form>
                        <div class="mt-6 text-left">
                            <a href="{{ route('login') }}" class="text-[#002837] hover:underline">Already Have an Account?</a>
                        </div>
                        <div class="mt-6 text-center">
                            <p class="text-gray-600 mb-3">Sign Up With</p>
                            <div class="flex justify-center">
                                <button class="w-12 h-12 bg-[#002837] text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:flex items-stretch justify-stretch p-0">
                        <img src="{{ asset('assets/image/Frame Ilustrasi.png') }}" alt="Renewable Energy Illustration" class="w-full h-full object-cover rounded-r-2xl">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="registerModal" style="display:none" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-xs text-center">
        <div class="text-lg font-semibold text-[#002837] mb-4" id="registerModalMsg">Akun berhasil dibuat, menunggu persetujuan admin</div>
        <button id="registerOkBtn" onclick="closeRegisterModalAndRedirect()" class="mt-2 px-6 py-2 bg-[#002837] text-white rounded-lg font-semibold hover:bg-blue-800">OK</button>
      </div>
    </div>
    <div id="registerError" style="display:none" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
      <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-xs text-center">
        <div class="text-lg font-semibold text-red-700 mb-4">Isi semua form terlebih dahulu</div>
        <button onclick="document.getElementById('registerError').style.display='none'" class="mt-2 px-6 py-2 bg-[#002837] text-white rounded-lg font-semibold hover:bg-blue-800">OK</button>
      </div>
    </div>
@endsection

@push('scripts')
<script>
function registerHandler() {
    const nama = document.querySelector('input[placeholder="Enter your name"]');
    const nip = document.getElementById('nipInput');
    const email = document.querySelector('input[type="email"]');
    const password = document.querySelector('input[type="password"]');
    let empty = false;
    if (!nama.value || !nip.value || !email.value || !password.value) {
        empty = true;
    }
    if (empty) {
        document.getElementById('registerError').style.display = 'flex';
        return;
    }
    // jika lengkap tampilkan popup menunggu persetujuan admin
    document.getElementById('registerModalMsg').innerText = 'Akun berhasil dibuat, menunggu persetujuan admin';
    document.getElementById('registerModal').style.display = 'flex';
}
function closeRegisterModalAndRedirect() {
    document.getElementById('registerModal').style.display = 'none';
    window.location.href = '/';
}
// Option: hide error popup jika user mulai mengisi input setelah error
const errorPopup = document.getElementById('registerError');
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('input', function() {
        if(errorPopup) errorPopup.style.display = 'none';
    });
});
</script>
@endpush
