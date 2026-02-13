@extends('layouts.master')

@section('title', 'Fest Connection || Join Beta')

@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden" x-data="inviteRegistration()">
    <!-- Video Background -->
    <x-video-background source="img/video/login_bg.mp4" />

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-md px-4">

        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8 shadow-2xl">

            <!-- Logo area -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white tracking-wide">Beta<span class="text-purple-400">Invite</span>
                </h1>
                <p class="text-gray-300 text-sm mt-2"
                    x-text="step === 1 ? 'Enter your invite code to begin' : 'Complete your registration'"></p>
            </div>

            <!-- Step 1: Invite Code -->
            <div x-show="step === 1" class="space-y-4">
                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Invite Code</label>
                    <input type="text" x-model="inviteCode" @keyup.enter="verifyCode()"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition uppercase"
                        placeholder="ENTER-CODE-HERE" />
                </div>

                <div x-show="error" class="text-red-400 text-sm text-center" x-text="error"></div>

                <button @click="verifyCode()" :disabled="loading"
                    class="w-full py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg transform hover:scale-[1.02] transition-all disabled:opacity-50">
                    <span x-show="!loading">Verify Code</span>
                    <span x-show="loading">Verifying...</span>
                </button>
            </div>

            <!-- Step 2: Registration Fields -->
            <div x-show="step === 2" class="space-y-4" x-cloak>
                <div class="flex items-center gap-2 mb-4 p-3 bg-green-500/20 border border-green-500/30 rounded-lg">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-green-400 text-xs font-bold uppercase tracking-wider">Code Applied: <span
                            x-text="inviteCode"></span></span>
                </div>

                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Username</label>
                    <input type="text" x-model="formData.name"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="FestivalFam" />
                </div>
                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Email</label>
                    <input type="email" x-model="formData.email"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="you@example.com" />
                </div>
                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Password</label>
                    <input type="password" x-model="formData.password"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="••••••••" />
                </div>
                <div>
                    <label class="block text-gray-300 text-xs uppercase font-bold mb-2">Confirm Password</label>
                    <input type="password" x-model="formData.password_confirmation"
                        class="w-full px-4 py-3 rounded-lg bg-black/30 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="••••••••" />
                </div>

                <div x-show="error" class="text-red-400 text-sm text-center" x-text="error"></div>

                <div class="flex gap-4 pt-2">
                    <button @click="step = 1"
                        class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 font-bold rounded-lg transition">Back</button>
                    <button @click="submitRegistration()" :disabled="loading"
                        class="flex-1 py-3 bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white font-bold rounded-lg shadow-lg transform hover:scale-[1.02] transition-all disabled:opacity-50">
                        <span x-show="!loading">Create Account</span>
                        <span x-show="loading">Registering...</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    function inviteRegistration() {
        return {
            step: 1,
            loading: false,
            error: '',
            inviteCode: '',
            formData: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            init() {
                const urlParams = new URLSearchParams(window.location.search);
                const code = urlParams.get('code');
                if (code) {
                    this.inviteCode = code.toUpperCase();
                    // Auto-verify if code is present
                    this.verifyCode();
                }
            },
            async verifyCode() {
                if (!this.inviteCode) {
                    this.error = 'Please enter an invite code.';
                    return;
                }
                this.loading = true;
                this.error = '';
                try {
                    const res = await fetch('/verify_code', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ code: this.inviteCode })
                    });
                    const data = await res.json();
                    if (data.status === 'success') {
                        this.step = 2;
                    } else {
                        this.error = data.message;
                    }
                } catch (e) {
                    this.error = 'An error occurred. Please try again.';
                } finally {
                    this.loading = false;
                }
            },
            async submitRegistration() {
                if (!this.formData.name || !this.formData.email || !this.formData.password) {
                    this.error = 'All fields are required.';
                    return;
                }
                if (this.formData.password !== this.formData.password_confirmation) {
                    this.error = 'Passwords do not match.';
                    return;
                }
                this.loading = true;
                this.error = '';
                try {
                    const res = await fetch('/register_beta', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            invite_code: this.inviteCode,
                            ...this.formData
                        })
                    });
                    const data = await res.json();
                    if (data.status === 'success') {
                        window.location.href = data.redirect;
                    } else {
                        this.error = data.message;
                    }
                } catch (e) {
                    this.error = 'An error occurred. Please try again.';
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@stop