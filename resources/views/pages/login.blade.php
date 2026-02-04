@extends('layouts.master')

@section('title', 'Fest Connection || Login')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Video Background -->
    <x-video-background source="img/video/login_bg.mp4" />

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-md px-4">

        <!-- Toggle Buttons -->
        <div class="flex mb-6 bg-white/10 p-1 rounded-full backdrop-blur-md">
            <button id="show-signin"
                class="flex-1 py-2 rounded-full text-white font-semibold text-sm transition-all bg-purple-600 shadow-lg">
                Sign In
            </button>
            <button id="show-signup"
                class="flex-1 py-2 rounded-full text-white font-semibold text-sm transition-all hover:bg-white/10">
                Sign Up
            </button>
        </div>

        <!-- Forms Container -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 shadow-2xl">

            <!-- Logo area -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white tracking-wide">Fest<span class="text-purple-400">Connect</span>
                </h1>
                <p class="text-gray-300 text-sm mt-2">Find your missed connection</p>
            </div>

            <!-- Login Form -->
            <form id="form_login" action="#" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Email</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="you@example.com" required />
                </div>
                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="••••••••" required />
                </div>

                <div class="flex justify-between items-center text-sm">
                    <a href="#" class="text-purple-400 hover:text-purple-300 transition">Forgot Password?</a>
                </div>

                <div class="err_message text-red-400 text-sm text-center hidden"></div>

                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg transform hover:scale-[1.02] transition-all">
                    Sign In
                </button>
            </form>

            <!-- Register Form (Hidden by default) -->
            <form id="form_register" action="#" class="space-y-4 hidden">
                @csrf
                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Username</label>
                    <input type="text" name="name"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="FestivalFam" required />
                </div>
                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Email</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="you@example.com" required />
                </div>
                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="Create a password" required />
                </div>

                <div class="err_message text-red-400 text-sm text-center hidden"></div>

                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white font-bold rounded-lg shadow-lg transform hover:scale-[1.02] transition-all">
                    Create Account
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/10 text-center">
                <p class="text-gray-400 text-sm">Or continue with</p>
                <div class="flex justify-center space-x-4 mt-4">
                    <!-- <a href="#"
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                        <i class="fab fa-facebook-f"></i>
                    </a> -->
                    <a href="/auth/google"
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                        <i class="fab fa-google"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Inline script for toggle logic since we removed the complicated sliding login.js logic dependence
    document.addEventListener('DOMContentLoaded', () => {
        const signInBtn = document.getElementById('show-signin');
        const signUpBtn = document.getElementById('show-signup');
        const loginForm = document.getElementById('form_login');
        const registerForm = document.getElementById('form_register');

        signInBtn.addEventListener('click', () => {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            signInBtn.classList.add('bg-purple-600', 'shadow-lg');
            signInBtn.classList.remove('hover:bg-white/10');
            signUpBtn.classList.remove('bg-purple-600', 'shadow-lg');
            signUpBtn.classList.add('hover:bg-white/10');
        });

        signUpBtn.addEventListener('click', () => {
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            signUpBtn.classList.add('bg-purple-600', 'shadow-lg');
            signUpBtn.classList.remove('hover:bg-white/10');
            signInBtn.classList.remove('bg-purple-600', 'shadow-lg');
            signInBtn.classList.add('hover:bg-white/10');
        });
    });
</script>
@stop