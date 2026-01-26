@extends('layouts.master')

@section('title', 'Fest Connection || About')

@section('content')
<div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
    <!-- Video Background -->
    <x-video-background source="img/video/about_bg.mp4" />

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-6 py-12 flex flex-col items-center max-w-4xl">

        <h1
            class="text-4xl md:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400 mb-8 text-center drop-shadow-md">
            About Fest Connection
        </h1>

        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-2xl mb-8 w-full">
            <div class="space-y-6 text-gray-200 text-lg leading-relaxed font-light">
                <p>
                    <span class="font-bold text-white text-xl">Fest Connection</span> was born from a simple idea: that
                    the magic of a festival doesn't have to end when the music stops.
                </p>
                <p>
                    We've all been there – that fleeting moment in the crowd, a shared laugh at a campsite, or a
                    beautiful soul you danced with but lost in the shuffle. These connections are rare and precious, and
                    they shouldn't be lost to memory.
                </p>
                <p>
                    Our mission is to provide a safe, dedicated space for festival-goers to reconnect, share their
                    stories, and build a community that transcends the event grounds.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
            <div class="p-6 bg-purple-900/30 border border-purple-500/20 rounded-xl text-center">
                <div class="text-4xl mb-4">🤝</div>
                <h3 class="text-xl font-bold text-white mb-2">Reconnect</h3>
                <p class="text-sm text-gray-400">Find the friends you didn't get a chance to swap numbers with.</p>
            </div>
            <div class="p-6 bg-pink-900/30 border border-pink-500/20 rounded-xl text-center">
                <div class="text-4xl mb-4">🎭</div>
                <h3 class="text-xl font-bold text-white mb-2">Discover</h3>
                <p class="text-sm text-gray-400">Locate unmatched vendors, artists, and performers.</p>
            </div>
            <div class="p-6 bg-indigo-900/30 border border-indigo-500/20 rounded-xl text-center">
                <div class="text-4xl mb-4">✨</div>
                <h3 class="text-xl font-bold text-white mb-2">Share</h3>
                <p class="text-sm text-gray-400">Share your festival magic and keepsakes with the community.</p>
            </div>
        </div>

    </div>
</div>
@stop