@extends('layout')

@section('title', 'Register - UP2D Pasundan')
@section('bodyClass', 'bg-white min-h-screen')

@section('content')
    <main class="container mx-auto px-4 py-12">
        <div class="flex justify-center items-center min-h-[calc(100vh-200px)]">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    <div class="p-8 md:p-12">
                        <h1 class="font-serif-title text-4xl md:text-5xl font-bold text-[#002837] mb-10 text-center">
                            Register</h1>
                        <form class="space-y-6" method="POST" action="{{ route('register.store') }}">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">Nama</label>
                                    <input name="name" type="text" class="w-full px-4 py-3 rounded-lg focus:outline-none"
                                        style="background-color:#f5f5f5;border:none" placeholder="Enter your name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><svg class="w-4 h-4"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-medium mb-2">NIP</label>
                                    <input name="NIP" type="text" class="w-full px-4 py-3 rounded-lg focus:outline-none"
                                        style="background-color:#f5f5f5;border:none" placeholder="Masukkan NIP"
                                        value="{{ old('NIP') }}" required>
                                    @error('NIP')
                                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><svg class="w-4 h-4"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Email</label>
                                <input name="email" type="email" class="w-full px-4 py-3 rounded-lg focus:outline-none"
                                    style="background-color:#f5f5f5;border:none" placeholder="Enter your email"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><svg class="w-4 h-4"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Password</label>
                                <div class="relative">
                                    <input name="password" type="password" id="registerPassword"
                                        class="w-full px-4 py-3 rounded-lg focus:outline-none pr-12"
                                        style="background-color:#f5f5f5;border:none" placeholder="Enter your password"
                                        required>
                                    <button type="button" onclick="togglePassword('registerPassword', 'regPassEyeIcon')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg id="regPassEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><svg class="w-4 h-4"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                                <div class="relative">
                                    <input name="password_confirmation" type="password" id="confirmPassword"
                                        class="w-full px-4 py-3 rounded-lg focus:outline-none pr-12"
                                        style="background-color:#f5f5f5;border:none" placeholder="Confirm your password"
                                        required>
                                    <button type="button" onclick="togglePassword('confirmPassword', 'confirmPassEyeIcon')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg id="confirmPassEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><svg class="w-4 h-4"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" onclick="registerHandler()"
                                class="w-full bg-[#002837] text-white py-3 rounded-lg font-serif-title font-bold text-lg hover:bg-blue-800 transition">
                                Register
                            </button>
                        </form>
                        <div class="mt-6 text-left">
                            <a href="{{ route('login') }}" class="text-[#002837] hover:underline">Already Have an
                                Account?</a>
                        </div>

                    </div>
                    <div class="hidden md:flex items-stretch justify-stretch p-0">
                        <img src="{{ asset('assets/image/Frame Ilustrasi.png') }}" alt="Renewable Energy Illustration"
                            class="w-full h-full object-cover rounded-r-2xl">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="registerModal" style="display:none"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-xs text-center">
            <div class="text-lg font-semibold text-[#002837] mb-4" id="registerModalMsg">Akun berhasil dibuat, menunggu
                persetujuan admin</div>
            <button id="registerOkBtn" onclick="closeRegisterModalAndRedirect()"
                class="mt-2 px-6 py-2 bg-[#002837] text-white rounded-lg font-semibold hover:bg-blue-800">OK</button>
        </div>
    </div>
    <div id="registerError" style="display:none"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-xs text-center">
            <div class="text-lg font-semibold text-red-700 mb-4">Isi semua form terlebih dahulu</div>
            <button onclick="document.getElementById('registerError').style.display='none'"
                class="mt-2 px-6 py-2 bg-[#002837] text-white rounded-lg font-semibold hover:bg-blue-800">OK</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        function registerHandler() {
            const nama = document.querySelector('input[placeholder="Enter your name"]');
            const nip = document.getElementById('nipInput');
            const email = document.querySelector('input[type="email"]');
            const password = document.getElementById('registerPassword');
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
            input.addEventListener('input', function () {
                if (errorPopup) errorPopup.style.display = 'none';
            });
        });
    </script>
@endpush