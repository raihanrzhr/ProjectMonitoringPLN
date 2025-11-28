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
                                <label class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" class="w-full px-4 py-3 rounded-lg focus:outline-none" style="background-color:#f5f5f5;border:none" placeholder="Email">
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

                    </div>
                    <div class="hidden md:flex items-stretch justify-stretch p-0">
                        <img src="{{ asset('assets/image/Frame Ilustrasi.png') }}" alt="Renewable Energy Illustration" class="w-full h-full object-cover rounded-r-2xl">
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

