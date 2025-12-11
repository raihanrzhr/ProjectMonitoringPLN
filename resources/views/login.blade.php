@extends('layout')

@section('title', 'Login - UP2D Pasundan')
@section('bodyClass', 'bg-white min-h-screen')

@section('content')
    <main class="container mx-auto px-4 py-12">
        <div class="flex justify-center items-center min-h-[calc(100vh-200px)]">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    <div class="p-8 md:p-12">
                        <h1 class="font-serif-title text-4xl md:text-5xl font-bold text-[#002837] mb-10 text-center">Login
                        </h1>

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">

                            @csrf

                            @if ($errors->any())
                                <div class="text-red-500 text-sm text-center mb-4">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif

                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-3 rounded-lg focus:outline-none @error('email') border border-red-500 @enderror"
                                    style="background-color:#f5f5f5;border:none" placeholder="Email" required autofocus>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-gray-700 font-medium">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                            class="text-[#002837] hover:underline text-sm">Forgot Password?</a>
                                    @endif
                                </div>
                                <div class="relative">
                                    <input type="password" name="password" id="loginPassword"
                                        class="w-full px-4 py-3 rounded-lg focus:outline-none pr-12 @error('password') border border-red-500 @enderror"
                                        style="background-color:#f5f5f5;border:none" placeholder="Password" required>
                                    <button type="button" onclick="togglePassword('loginPassword', 'loginEyeIcon')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg id="loginEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember"
                                    class="w-4 h-4 text-blue-900 bg-gray-200 border-gray-300 rounded focus:ring-blue-900">
                                <label for="remember" class="ml-2 text-gray-700">Remember Me?</label>
                            </div>

                            <button type="submit"
                                class="w-full bg-[#002837] text-white py-3 rounded-lg font-serif-title font-bold text-lg hover:bg-blue-800 transition">
                                Login
                            </button>
                        </form>

                        <div class="mt-6 text-left">
                            <a href="{{ route('register') }}" class="text-[#002837] hover:underline">Don't Have an
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
        </script>
    @endpush

@endsection