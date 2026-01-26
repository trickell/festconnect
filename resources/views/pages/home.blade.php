@extends('layouts.master')

@section('title', 'Fest Connection || Home')

@section('content')
<div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
    <!-- Video Background -->
    <x-video-background source="img/video/home_bg.mp4" />

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-4 py-16 flex flex-col items-center">

        <!-- Logo Section -->
        <div class="mb-12 text-center group">
            <img src="{{ asset('/img/festconnection_logo.png') }}" alt="Fest Connection Logo"
                class="md:w-88 h-auto mx-auto drop-shadow-2xl transition-transform duration-300 group-hover:scale-105 group-hover:hidden">
            <img src="{{ asset('/img/festconnection_logo_hover.png') }}" alt="Fest Connection Logo Hover"
                class="md:w-88 h-auto mx-auto drop-shadow-2xl transition-transform duration-300 group-hover:scale-105 hidden group-hover:block">
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-4xl">

            <!-- Missed Connection Card -->
            <a href="{{ url('missed_connections') }}"
                class="group relative overflow-hidden p-8 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl hover:bg-white/20 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2 group-hover:text-purple-300 transition">Find a
                            Missed Connection</h2>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Find a lost connection or friend made at a festival. Reconnect with the people who made your
                            experience magical.
                        </p>
                    </div>
                    <div class="bg-purple-600/20 p-3 rounded-full group-hover:bg-purple-600/40 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Find Vendor Card -->
            <a href="#"
                class="group relative overflow-hidden p-8 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl hover:bg-white/20 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2 group-hover:text-pink-300 transition">Find a
                            Vendor</h2>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Discover that amazing food vendor, art piece, or clothing stall from an event you recently
                            attended.
                        </p>
                    </div>
                    <div class="bg-pink-600/20 p-3 rounded-full group-hover:bg-pink-600/40 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-300" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
            </a>

        </div>
    </div>
</div>
@stop