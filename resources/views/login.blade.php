@extends('layout')

@section('title', 'Login - UP2D Pasundan')
@section('bodyClass', 'bg-white min-h-screen')

@section('content')
    <main class="container mx-auto px-4 py-12">
        <div class="flex justify-center items-center min-h-[calc(100vh-200px)]">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-0">
                    <div class="p-8 md:p-12">
                        <h1 class="font-serif-title text-4xl md:text-5xl font-bold text-blue-900 mb-10 text-center">Login</h1>
                        <form class="space-y-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Username or email</label>
                                <input type="text" class="w-full px-4 py-3 rounded-lg focus:outline-none" style="background-color:#f5f5f5;border:none" placeholder="Username or email">
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-gray-700 font-medium">Password</label>
                                    <a href="#" class="text-blue-900 hover:underline text-sm">Forgot Password?</a>
                                </div>
                                <input type="password" class="w-full px-4 py-3 rounded-lg focus:outline-none" style="background-color:#f5f5f5;border:none" placeholder="Password">
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="remember" class="w-4 h-4 text-blue-900 bg-gray-200 border-gray-300 rounded focus:ring-blue-900">
                                <label for="remember" class="ml-2 text-gray-700">Remember Me?</label>
                            </div>
                            <button type="submit" class="w-full bg-blue-900 text-white py-3 rounded-lg font-serif-title font-bold text-lg hover:bg-blue-800 transition">
                                Login
                            </button>
                        </form>
                        <div class="mt-6 text-left">
                            <a href="{{ route('register') }}" class="text-blue-900 hover:underline">Don't Have an Account?</a>
                        </div>
                        <div class="mt-6 text-center">
                            <p class="text-gray-600 mb-3">Login With</p>
                            <div class="flex justify-center">
                                <button class="w-12 h-12 bg-blue-900 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition">
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
@endsection

