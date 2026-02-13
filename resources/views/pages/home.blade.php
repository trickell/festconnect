@extends('layouts.master')

@section('title', 'Fest Connection || Home')

@section('content')
<div x-data="betaInviteForm()" class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
    <!-- Video Background -->
    <x-video-background source="img/video/home_bg.mp4" />

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-4 py-16 flex flex-col items-center">

        <!-- Logo Section -->
        <div class="mb-12 text-center group static relative">
            <img src="{{ asset('/img/festconnection_logo.png') }}" alt="Fest Connection Logo"
                class="md:w-88 h-auto mx-auto drop-shadow-2xl transition-transform duration-300 group-hover:scale-105 group-hover:hidden">
            <img src="{{ asset('/img/festconnection_logo_hover.png') }}" alt="Fest Connection Logo Hover"
                class="md:w-88 h-auto mx-auto drop-shadow-2xl transition-transform duration-300 group-hover:scale-105 hidden group-hover:block">
            <h2
                class="absolute inset-x-4 -inset-y-4 text-6xl font-black text-orange-500 text-shadow-lg italic uppercase tracking-tighter">
                Beta 0.1
            </h2>
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
            <a href="#" @click.prevent="showVendorSoon = true"
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

        <!-- Beta Invite System -->
        <div id="beta-invite-section" class="mt-16 w-full max-w-xl transition-all duration-700"
            :class="highlight ? 'scale-105 ring-4 ring-purple-300 ring-offset-8 ring-offset-black rounded-3xl animate-pulse-glow' : ''">

            <div
                class="bg-white/5 backdrop-blur-xl border border-white/10 p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                <!-- Background Glow -->
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/20 blur-3xl rounded-full"></div>
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-pink-600/20 blur-3xl rounded-full"></div>

                <div class="relative z-10 text-center space-y-6">
                    <div>
                        <h2 class="text-3xl font-black italic uppercase tracking-tighter text-white">Get Early Access
                        </h2>
                        <p class="text-gray-400 text-sm font-medium mt-1">We're currently in invite-only beta. Sign up
                            to receive your code!</p>
                    </div>

                    <form @submit.prevent="submitInvite" class="space-y-4">
                        <div class="relative text-left">
                            <input type="email" x-model="email" required
                                :class="status === 'duplicate' ? 'border-red-500 ring-2 ring-red-500/20' : 'border-white/10'"
                                class="w-full bg-black/40 border rounded-2xl px-6 py-4 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 transition shadow-inner"
                                placeholder="Enter your email address" />
                            <button type="submit" :disabled="loading"
                                class="absolute right-2 top-2 bottom-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white px-6 rounded-xl font-bold uppercase tracking-widest transition shadow-lg disabled:opacity-50">
                                <span x-show="!loading">Get Invited</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>

                    <div x-show="message"
                        :class="(status === 'duplicate' || status === 'error') ? 'text-red-400' : 'text-green-400'"
                        class="text-xs font-bold uppercase tracking-widest animate-fade-in text-center" x-text="message"
                        x-cloak>
                    </div>
                </div>
            </div>

            <div class="m-4 text-center">
                <a href="{{ url('/invitecode') }}"
                    class="text-gray-500 hover:text-purple-400 text-[10px] font-black uppercase tracking-[0.3em] transition p10">Already
                    have a code? Register here</a>
            </div>
        </div>
    </div>

    <!-- Vendor Coming Soon Modal -->
    <div x-show="showVendorSoon" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/90 backdrop-blur-md" x-cloak>
        <div class="bg-gray-900 border border-white/10 rounded-[2.5rem] w-full max-w-lg p-10 shadow-2xl relative overflow-hidden text-center"
            @click.away="showVendorSoon = false">

            <!-- Glow Effect -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-pink-600/20 blur-3xl rounded-full"></div>

            <div class="relative z-10 space-y-8">
                <!-- Icon -->
                <div
                    class="w-20 h-20 bg-pink-600/10 rounded-3xl flex items-center justify-center mx-auto border border-pink-500/20">
                    <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-3xl font-black italic uppercase tracking-tighter text-white mb-2">Coming Soon</h2>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Our vendor discovery feature is currently in production. We can't wait to show you what we're
                        building!
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <a href="{{ url('missed_connections') }}"
                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 py-4 rounded-2xl font-black uppercase tracking-widest transition shadow-xl shadow-purple-600/20 active:scale-95 text-white text-sm">
                        Visit Missed Connections
                    </a>
                    <button @click="showVendorSoon = false"
                        class="w-full bg-white/5 hover:bg-white/10 py-4 rounded-2xl font-bold uppercase tracking-widest transition text-gray-400 text-xs">
                        Maybe Later
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function betaInviteForm() {
        return {
            email: '',
            loading: false,
            message: '',
            status: '',
            showVendorSoon: false,
            highlight: new URLSearchParams(window.location.search).has('highlight'),
            init() {
                if (this.highlight) {
                    setTimeout(() => {
                        const el = document.getElementById('beta-invite-section');
                        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 500);
                }
            },
            async submitInvite() {
                this.loading = true;
                this.message = '';
                try {
                    const res = await fetch('/request_beta', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: this.email })
                    });
                    const data = await res.json();
                    this.status = data.status;
                    this.message = data.message;
                    if (data.status === 'success') this.email = '';
                } catch (e) {
                    this.status = 'error';
                    this.message = 'Something went wrong. Please try again.';
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>

<style>
    @keyframes pulse-glow {

        0%,
        100% {
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.2);
        }

        50% {
            box-shadow: 0 0 60px rgba(188, 116, 255, 1);
        }
    }

    .animate-pulse-glow {
        animation: pulse-glow 2s infinite;
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    [x-cloak] {
        display: none !important;
    }
</style>
@stop