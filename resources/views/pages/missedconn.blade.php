@extends('layouts.master')

@section('title', 'Fest Connection || Missed and Shared Connections')

@section('content')

<div class="relative min-h-screen flex flex-col justify-center items-center overflow-hidden">
    <!-- Video Background -->
    <x-video-background source="img/video/missedconn_bg.mp4" />

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-6 py-12 flex flex-col items-center max-w-5xl">

        <h1
            class="text-4xl md:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400 mb-8 text-center drop-shadow-md">
            Missed & Shared Connections
        </h1>

        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-2xl mb-12">
            <p class="text-gray-200 text-lg md:text-xl leading-relaxed text-center font-light">
                Moments that slipped away can find their way back to you! Festivals are full of fleeting interactions
                and unforgettable experiences, but sometimes, the hustle and excitement means you miss the chance to
                reconnect.
                <span class="block mt-4 text-white font-medium">Whether it was a brief conversation, a shared glance, or
                    a helping hand - this is the place to reconnect.</span>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full">
            <!-- Reconnection Card -->
            <a href="/reconnections"
                class="group relative p-8 bg-purple-900/40 border border-purple-500/30 rounded-2xl hover:bg-purple-900/60 transition-all duration-300 hover:shadow-[0_0_30px_rgba(168,85,247,0.4)] hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-600/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="relative z-10 text-center">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-purple-500/20 rounded-full flex items-center justify-center group-hover:bg-purple-500/40 transition">
                        <svg class="w-8 h-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Lost Connection</h3>
                    <p class="text-gray-300">Submit a post to find someone you met!</p>
                </div>
            </a>

            <!-- Share Zone Card -->
            <a href="/share_zone"
                class="group relative p-8 bg-pink-900/40 border border-pink-500/30 rounded-2xl hover:bg-pink-900/60 transition-all duration-300 hover:shadow-[0_0_30px_rgba(236,72,153,0.4)] hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-pink-600/10 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity">
                </div>
                <div class="relative z-10 text-center">
                    <div
                        class="w-16 h-16 mx-auto mb-4 bg-pink-500/20 rounded-full flex items-center justify-center group-hover:bg-pink-500/40 transition">
                        <svg class="w-8 h-8 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Festival Share Zone</h3>
                    <p class="text-gray-300">Share images, finds, or gifts with the community.</p>
                </div>
            </a>
        </div>
    </div>
</div>
@stop