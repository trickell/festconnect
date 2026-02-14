@extends('layouts.master')

@section('title', 'Fest Connection || User Profile')

@section('content')
<div x-data="{
    tab: new URLSearchParams(window.location.search).get('tab') || 'info',
    unreadCount: 0,
    threads: [],
    activeThreadId: null,
    editingMsgId: null,
    editContent: '',
    showWelcomeModal: {{ (!$user->has_seen_welcome && $isOwner) ? 'true' : 'false' }},
    generatedInvites: @js($generatedInvites ?? []),
    passwordUnlocked: false,
    sliderProgress: 0,
    isDragging: false,
    resetPasswordLock() {
        this.passwordUnlocked = false;
        this.sliderProgress = 0;
    },
    async fetchThreads() {
        try {
            const res = await fetch('/get_messages');
            const data = await res.json();
            this.threads = Array.isArray(data) ? data : [];
            this.unreadCount = this.threads.reduce((acc, t) => acc + (t.unread_count || 0), 0);
        } catch (e) { 
            console.error('Error fetching threads'); 
            this.threads = [];
        }
    },
    async sendReply(partnerId) {
        const form = document.getElementById('reply_form_' + partnerId);
        const formData = new FormData(form);
        formData.append('receiver_id', partnerId);
        
        try {
            const res = await fetch('/send_message', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const data = await res.json();
            if (data.status === 'success') {
                const thread = this.threads.find(t => t.partner.id === partnerId);
                if (thread) thread.messages.push(data.message);
                form.reset();
            }
        } catch (e) { alert('Error sending reply'); }
    },
    async markRead(partnerId) {
        try {
            await fetch('/mark_read', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ partner_id: partnerId })
            });
            this.fetchThreads();
        } catch (e) {}
    },
    async saveEdit(id, partnerId) {
        try {
            const res = await fetch('/update_message/' + id, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ message: this.editContent })
            });
            const data = await res.json();
            if (data.status === 'success') {
                const thread = this.threads.find(t => t.partner.id === partnerId);
                if (thread) {
                    const msg = thread.messages.find(m => m.id === id);
                    if (msg) {
                        msg.message = data.message.message;
                        msg.is_edited = true;
                        msg.updated_at = data.message.updated_at;
                    }
                }
                this.editingMsgId = null;
            }
        } catch (e) { alert('Error saving edit'); }
    },
    async deleteMsg(id, partnerId) {
        if (!confirm('Remove this message from your view?')) return;
        try {
            const res = await fetch('/delete_message/' + id, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const data = await res.json();
            if (data.status === 'success') {
                const thread = this.threads.find(t => t.partner.id === partnerId);
                if (thread) thread.messages = thread.messages.filter(m => m.id !== id);
            }
        } catch (e) { alert('Error deleting'); }
    },
    async markWelcomeSeen() {
        try {
            await fetch('/mark_welcome_seen', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            this.showWelcomeModal = false;
        } catch (e) {}
    },
    copyCode(code) {
        navigator.clipboard.writeText(code).then(() => {
            alert('Code copied to clipboard!');
        });
    },
    init() {
        this.fetchThreads();
        setInterval(() => this.fetchThreads(), 10000);
    }
}" @refresh-threads.window="fetchThreads()" class="relative min-h-screen py-24 bg-black text-white overflow-hidden">
    <!-- Video Background -->
    <x-video-background source="img/video/profile_bg.mp4" />

    <!-- Background Decor -->
    <div
        class="absolute top-0 left-0 w-full h-[500px] bg-gradient-to-b from-purple-900/20 to-transparent pointer-events-none">
    </div>
    <div
        class="absolute -top-24 -left-24 w-96 h-96 bg-pink-600/10 rounded-full blur-[120px] pointer-events-none animate-pulse">
    </div>

    <div class="relative z-10 container mx-auto px-4 max-w-6xl">
        <!-- Account Standing Summary (Visible only to OWNER or ADMIN) -->
        @if($isOwner || (optional($viewer)->role === 'admin'))
            <div class="mb-12 space-y-4">
                <div class="bg-white/5 border border-white/10 p-6 rounded-3xl flex items-center justify-between shadow-xl">
                    <div>
                        <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 mb-1">Account Standing
                        </h4>
                        <p
                            class="text-2xl font-black italic uppercase tracking-tighter @if($user->penalty_marks >= 5) text-red-500 @else text-white @endif">
                            {{ $user->penalty_marks }} / 5 Marks
                        </p>
                    </div>
                    @if($user->banned_until && $user->banned_until > now())
                        <div class="text-right">
                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-red-500 mb-1">BANNED (Read-Only)
                            </h4>
                            <p class="text-sm font-bold text-gray-400">Lifts {{ $user->banned_until->diffForHumans() }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <div
            class="absolute top-1/2 -right-24 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[150px] pointer-events-none">
        </div>

        <div class="relative z-10 container mx-auto px-4 max-w-5xl">
            <!-- Profile Header -->
            <div class="flex flex-col md:flex-row items-center md:items-end gap-8 mb-12">
                <!-- Profile Image Container -->
                <div class="relative group">
                    <div
                        class="w-40 h-40 md:w-48 md:h-48 rounded-3xl overflow-hidden border-4 border-white/10 shadow-2xl relative">
                        <img id="profile_display"
                            src="{{ $user->profile_image ? asset($user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff&size=512' }}"
                            class="w-full h-full object-cover">

                        @if($isOwner)
                            <label for="img_upload"
                                class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <input type="file" id="img_upload" class="hidden" accept="image/*">
                            </label>
                        @endif
                    </div>
                    @php
                        $lastSeen = $user->last_seen_at;
                        $isOnline = $lastSeen && now()->diffInMinutes($lastSeen) < 2;
                        $statusColor = $isOnline ? 'bg-green-500 shadow-[0_0_15px_rgba(34,197,94,0.5)]' : 'bg-red-500 shadow-[0_0_15px_rgba(239,68,68,0.5)]';
                    @endphp
                    <div id="status_indicator"
                        class="absolute -bottom-2 -right-2 {{ $statusColor }} w-6 h-6 rounded-full border-4 border-black transition-colors duration-500">
                    </div>
                </div>

                <div class="flex-grow text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-4 mb-2 group/user-main pt-6">
                        <h1
                            class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-white/40">
                            {{ $user->name }}
                        </h1>
                        @if(!$isOwner && $viewer)
                            <button onclick="initiateMessage({{ $user->id }}, '{{ $user->name }}')"
                                class="opacity-0 group-hover/user-main:opacity-100 transition-opacity p-2 bg-pink-600 hover:bg-pink-500 rounded-2xl text-white shadow-xl shadow-pink-600/20"
                                title="Message {{ $user->name }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </button>
                        @endif
                    </div>
                    <div
                        class="flex flex-wrap justify-center md:justify-start gap-4 text-sm font-bold uppercase tracking-widest text-gray-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                            {{ $user->posts->count() }} Posts
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Joined {{ $user->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>

                @if($isOwner || optional($viewer)->role === 'admin')
                    <div class="flex flex-col md:flex-row gap-4">
                        @if(optional($viewer)->role === 'admin')
                            <a href="{{ url('/admin/support') }}"
                                class="px-8 py-3 bg-indigo-600/20 hover:bg-indigo-600 border border-indigo-600/30 rounded-2xl font-bold transition flex items-center gap-2 text-sm uppercase tracking-widest text-indigo-400 hover:text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Admin Dashboard
                            </a>
                        @endif
                        <button onclick="toggleEditMode()" id="edit_btn"
                            class="px-8 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl font-bold transition flex items-center gap-2 text-sm uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            {{ $isOwner ? 'Edit Profile' : 'Admin: Edit Info' }}
                        </button>
                        @if(!$isOwner && optional($viewer)->role === 'admin')
                            <button onclick="openModFlagModal({{ $user->id }}, 'user')"
                                class="px-8 py-3 bg-red-600/20 hover:bg-red-600 border border-red-600/30 rounded-2xl font-bold transition flex items-center gap-2 text-sm uppercase tracking-widest text-red-500 hover:text-white">Flag
                                User</button>
                        @endif
                    </div>
                @endif
            </div>

            @if($isOwner || optional($viewer)->role === 'admin')
                <div class="flex flex-wrap gap-4 mb-12 border-b border-white/10 pb-6 relative z-10">
                    <button @click="tab = 'info'"
                        :class="tab === 'info' ? 'bg-purple-600 text-white shadow-lg shadow-purple-500/20' : 'bg-white/5 text-gray-400 hover:bg-white/10'"
                        class="px-8 py-3 rounded-2xl font-black uppercase tracking-widest transition text-xs">Profile
                        Info</button>
                    @if($isOwner)
                        <button @click="tab = 'posts'"
                            :class="tab === 'posts' ? 'bg-pink-600 text-white shadow-lg shadow-pink-500/20' : 'bg-white/5 text-gray-400 hover:bg-white/10'"
                            class="px-8 py-3 rounded-2xl font-black uppercase tracking-widest transition text-xs">My
                            Activity</button>
                        <button @click="tab = 'messages'; fetchThreads()"
                            :class="tab === 'messages' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-white/5 text-gray-400 hover:bg-white/10'"
                            class="px-8 py-3 rounded-2xl font-black uppercase tracking-widest transition text-xs relative flex items-center gap-2">
                            My Messages
                            <span x-show="unreadCount > 0"
                                class="flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] text-white animate-pulse"
                                x-text="unreadCount"></span>
                        </button>
                    @endif
                    @if($isOwner)
                        <button @click="tab = 'invites'"
                            :class="tab === 'invites' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/20' : 'bg-white/5 text-gray-400 hover:bg-white/10'"
                            class="px-8 py-3 rounded-2xl font-black uppercase tracking-widest transition text-xs">Invite
                            Codes</button>
                    @endif
                    <button @click="tab = 'penalties'"
                        :class="tab === 'penalties' ? 'bg-red-600 text-white shadow-lg shadow-red-500/20' : 'bg-white/5 text-gray-400 hover:bg-white/10'"
                        class="px-8 py-3 rounded-2xl font-black uppercase tracking-widest transition text-xs">Penalties</button>
                </div>
            @endif

            <div x-show="tab === 'info'" x-cloak class="animate-fade-in-up">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Info Column -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- About Me -->
                        <div
                            class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-purple-500/5 rotate-45 translate-x-16 -translate-y-16">
                            </div>
                            <h3
                                class="text-xl font-bold uppercase tracking-widest mb-6 text-purple-400 flex items-center gap-3">
                                <span class="w-2 h-2 bg-purple-400 rounded-full"></span> About Me
                            </h3>
                            <div id="about_text" class="text-gray-300 leading-relaxed italic text-lg">
                                {!! nl2br(e($user->about_me)) ?: '<span class="opacity-30 italic">No summary provided yet...</span>' !!}
                            </div>
                        </div>

                        <!-- Genres Display (Public) -->
                        @if(!$isOwner && $user->genres)
                            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
                                <h3
                                    class="text-xl font-bold uppercase tracking-widest mb-6 text-pink-400 flex items-center gap-3">
                                    <span class="w-2 h-2 bg-pink-400 rounded-full"></span> Music Preferences
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($user->genres as $genre)
                                        <span
                                            class="px-4 py-2 bg-gradient-to-tr from-pink-500/20 to-purple-500/20 border border-white/10 rounded-full text-xs font-bold text-white uppercase tracking-tighter">
                                            {{ $genre }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Festivals (Public) -->
                        @if(!$isOwner && $user->festivals)
                            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
                                <h3
                                    class="text-xl font-bold uppercase tracking-widest mb-6 text-indigo-400 flex items-center gap-3">
                                    <span class="w-2 h-2 bg-indigo-400 rounded-full"></span> Festivals Attended
                                </h3>
                                <div class="prose prose-invert max-w-none text-gray-300">
                                    {!! nl2br(e($user->festivals)) !!}
                                </div>
                            </div>
                        @endif

                        <!-- Moderator Activity (Visible to Moderator/Admin owner) -->
                        @if(($user->role === 'moderator') && count($modFlags) > 0)
                            <div
                                class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl relative overflow-hidden group mt-8">
                                <h3
                                    class="text-xl font-bold uppercase tracking-widest mb-6 text-pink-500 flex items-center gap-3">
                                    <span class="w-2 h-2 bg-pink-400 rounded-full"></span> Recent Moderation Activity
                                </h3>
                                <div class="space-y-4">
                                    @foreach($modFlags as $flag)
                                        <div
                                            class="p-4 bg-black/40 border border-white/5 rounded-2xl flex justify-between items-center group-hover:border-pink-500/20 transition-colors">
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Flagged
                                                    {{ $flag->target_type }} #{{ $flag->target_id }}
                                                </p>
                                                <p class="text-sm text-gray-200 mt-1 italic">
                                                    "{!! Str::limit($flag->reason, 80) !!}"
                                                </p>
                                            </div>
                                            <span
                                                class="px-2 py-1 rounded text-[8px] font-black uppercase tracking-tighter {{ $flag->status === 'pending' ? 'bg-pink-500/20 text-pink-400' : 'bg-gray-500/20 text-gray-500' }}">{{ $flag->status }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Edit Form (Hidden by default) -->
                        @if($isOwner || optional($viewer)->role === 'admin')
                            <form id="profile_form" class="hidden space-y-8 animate-fade-in-up">
                                @csrf
                                <div
                                    class="bg-white/5 backdrop-blur-xl border border-white/20 rounded-3xl p-8 shadow-2xl space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Email
                                                Address (Private)</label>
                                            <input type="email" value="{{ $user->email }}" disabled
                                                class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                                Change Password
                                            </label>
                                            <div class="relative group/pwd overflow-hidden rounded-xl h-[50px]">
                                                <input type="password" name="password" placeholder="••••••••"
                                                    x-ref="passwordInput" :disabled="!passwordUnlocked"
                                                    :class="passwordUnlocked ? 'bg-indigo-600/10 border-indigo-500 text-white' : 'bg-white/5 border-white/10 text-gray-500 cursor-not-allowed'"
                                                    class="w-full h-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all duration-500">

                                                <!-- Lock Overlay -->
                                                <div x-show="!passwordUnlocked"
                                                    x-transition:leave="transition ease-in duration-300 transform"
                                                    x-transition:leave-start="opacity-100 scale-100"
                                                    x-transition:leave-end="opacity-0 scale-95"
                                                    class="absolute inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center">

                                                    <!-- Lock Icon (Initial State) -->
                                                    <div x-show="sliderProgress === 0" class="flex items-center gap-3">
                                                        <div class="p-2 bg-white/5 rounded-lg">
                                                            <svg class="w-4 h-4 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                            </svg>
                                                        </div>
                                                        <span
                                                            class="text-[9px] font-black uppercase tracking-widest text-gray-400 opacity-50">Swipe
                                                            to unlock</span>
                                                    </div>

                                                    <!-- Slider Track -->
                                                    <div class="absolute inset-2 bg-white/5 rounded-lg overflow-hidden flex items-center"
                                                        @mousedown="isDragging = true"
                                                        @touchstart.passive="isDragging = true" @mousemove.window="if(isDragging) { 
                                                                        let rect = $el.getBoundingClientRect();
                                                                        let x = $event.clientX - rect.left;
                                                                        sliderProgress = Math.max(0, Math.min(100, (x / rect.width) * 100));
                                                                        if(sliderProgress >= 90) { 
                                                                            passwordUnlocked = true; 
                                                                            isDragging = false;
                                                                            $nextTick(() => { $refs.passwordInput.focus(); });
                                                                        }
                                                                    }" @touchmove.window.passive="if(isDragging) {
                                                                        let rect = $el.getBoundingClientRect();
                                                                        let x = $event.touches[0].clientX - rect.left;
                                                                        sliderProgress = Math.max(0, Math.min(100, (x / rect.width) * 100));
                                                                        if(sliderProgress >= 90) { 
                                                                            passwordUnlocked = true; 
                                                                            isDragging = false;
                                                                            $nextTick(() => { $refs.passwordInput.focus(); });
                                                                        }
                                                                    }"
                                                        @mouseup.window="if(isDragging && sliderProgress < 90) { sliderProgress = 0; isDragging = false; }"
                                                        @touchend.window="if(isDragging && sliderProgress < 90) { sliderProgress = 0; isDragging = false; }">

                                                        <!-- Progress Bar -->
                                                        <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-indigo-600/50 to-purple-600/50 transition-all duration-75"
                                                            :style="`width: ${sliderProgress}%` "></div>

                                                        <!-- Handle -->
                                                        <div class="absolute inset-y-1 w-10 bg-white rounded-md shadow-2xl flex items-center justify-center cursor-grab active:cursor-grabbing transition-all duration-75 z-10"
                                                            :style="`left: calc(${sliderProgress}% - ${sliderProgress > 10 ? '40px' : '0px'})` ">
                                                            <svg class="w-4 h-4 text-indigo-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                                            </svg>
                                                        </div>

                                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none"
                                                            x-show="sliderProgress < 50">
                                                            <span
                                                                class="text-[8px] font-black uppercase tracking-[0.2em] text-white/20">Slide
                                                                Right</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">About
                                            Me</label>
                                        <textarea name="about_me" rows="4"
                                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-purple-500 transition resize-none"
                                            placeholder="Tell the community about yourself...">{{ $user->about_me }}</textarea>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Festivals
                                            Attended</label>
                                        <textarea name="festivals" rows="3"
                                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-purple-500 transition resize-none"
                                            placeholder="Lost Lands 2023, EDC 2024...">{{ $user->festivals }}</textarea>
                                    </div>

                                    <!-- Custom Genre Selector -->
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Favorite
                                            Genres</label>
                                        <div class="space-y-6">
                                            <div>
                                                <h4
                                                    class="text-[10px] font-bold text-purple-400 uppercase tracking-[0.2em] mb-3">
                                                    EDM Genres</h4>
                                                <div class="flex flex-wrap gap-2" id="edm_genres_wrap">
                                                    @php $edm = ['Techno', 'House', 'Dubstep', 'Trance', 'Drum & Bass', 'Hardstyle', 'Melodic Dubstep', 'Psytrance', 'Future Bass', 'Trap']; @endphp
                                                    @foreach($edm as $g)
                                                        <button type="button" data-genre="{{ $g }}"
                                                            class="genre-chip px-3 py-1.5 border border-white/10 rounded-lg text-[10px] font-bold uppercase transition {{ in_array($g, (array) $user->genres) ? 'bg-purple-600 border-purple-500 text-white' : 'bg-white/5 text-gray-500 hover:border-white/30' }}">
                                                            {{ $g }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div>
                                                <h4
                                                    class="text-[10px] font-bold text-pink-400 uppercase tracking-[0.2em] mb-3">
                                                    Rock
                                                    Genres</h4>
                                                <div class="flex flex-wrap gap-2" id="rock_genres_wrap">
                                                    @php $rock = ['Alternative', 'Metal', 'Punk', 'Indie', 'Classic Rock', 'Hard Rock', 'Grunge', 'Progressive Rock', 'Psych Rock', 'Shoegaze']; @endphp
                                                    @foreach($rock as $g)
                                                        <button type="button" data-genre="{{ $g }}"
                                                            class="genre-chip px-3 py-1.5 border border-white/10 rounded-lg text-[10px] font-bold uppercase transition {{ in_array($g, (array) $user->genres) ? 'bg-pink-600 border-pink-500 text-white' : 'bg-white/5 text-gray-500 hover:border-white/30' }}">
                                                            {{ $g }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex gap-4 pt-4">
                                        <button type="submit"
                                            class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 py-4 rounded-2xl font-black uppercase tracking-widest transition shadow-lg shadow-purple-500/20 active:scale-95">Save
                                            Profile</button>
                                        <button type="button" onclick="toggleEditMode()"
                                            class="px-8 bg-white/5 hover:bg-white/10 py-4 rounded-2xl font-bold uppercase tracking-widest transition text-gray-400">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>

                    <!-- Right Sidebar -->
                    <div class="space-y-8">
                        <!-- Activity / Stats Card -->
                        <div
                            class="bg-gradient-to-br from-indigo-600/20 to-purple-600/20 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl relative overflow-hidden group">
                            <div
                                class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors">
                            </div>
                            <h3 class="text-xs font-bold uppercase tracking-[0.3em] mb-6 text-gray-400">Community Stats
                            </h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-bold text-gray-400">Contribution Level</span>
                                    <span
                                        class="px-2 py-0.5 bg-green-500/20 text-green-400 rounded text-[10px] font-black uppercase tracking-widest">Raver</span>
                                </div>
                                <div class="w-full bg-white/5 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-full w-2/3"></div>
                                </div>
                                <div
                                    class="text-[10px] text-gray-500 uppercase font-bold tracking-widest text-center mt-2 italic">
                                    More activity = Better perks!</div>
                            </div>
                        </div>

                        <!-- Own Genres / Festivals (Small Sidebar View) -->
                        @if($isOwner)
                            <div id="private_preview" class="space-y-8">
                                <!-- Genres -->
                                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl">
                                    <h4 class="text-[10px] font-bold uppercase tracking-widest mb-4 text-gray-400">My Genres
                                    </h4>
                                    <div class="flex flex-wrap gap-1.5" id="sidebar_genres">
                                        @if($user->genres)
                                            @foreach($user->genres as $g)
                                                <span
                                                    class="px-2 py-1 bg-white/5 border border-white/5 rounded text-[10px] font-bold text-gray-300">{{ $g }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-[10px] text-gray-600 italic">No genres selected...</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Manage Posts Section -->
            @if($isOwner)
                <div x-show="tab === 'posts'" x-cloak class="animate-fade-in-up space-y-6" x-data="{ 
                                                                                                            posts: @js($user->posts->map(fn($p) => [
                                                                                                                'id' => $p->id,
                                                                                                                'category' => $p->category ?? 'Chat',
                                                                                                                'post' => $p->post,
                                                                                                                'created_at' => $p->created_at->toDateTimeString(),
                                                                                                                'updated_at' => $p->updated_at->toDateTimeString(),
                                                                                                                'diff' => $p->created_at->diffForHumans(),
                                                                                                                'updated_diff' => $p->updated_at->diffForHumans(),
                                                                                                                'is_updated' => $p->created_at != $p->updated_at,
                                                                                                                'images' => $p->images ?? []
                                                                                                            ])),
                                                                                                            sortBy: 'newest',
                                                                                                            editingId: null,
                                                                                                            editContent: '',
                                                                                                            get sortedPosts() {
                                                                                                                let sorted = [...this.posts];
                                                                                                                if (this.sortBy === 'newest') {
                                                                                                                    return sorted.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                                                                                                                } else if (this.sortBy === 'oldest') {
                                                                                                                    return sorted.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                                                                                                                } else if (this.sortBy === 'type') {
                                                                                                                    return sorted.sort((a, b) => a.category.localeCompare(b.category));
                                                                                                                }
                                                                                                                return sorted;
                                                                                                            },
                                                                                                            async savePost(id) {
                                                                                                                try {
                                                                                                                    const res = await fetch('/update_post/' + id, {
                                                                                                                        method: 'POST',
                                                                                                                        headers: { 
                                                                                                                            'Content-Type': 'application/json',
                                                                                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                                                                                                                        },
                                                                                                                        body: JSON.stringify({ post: this.editContent })
                                                                                                                    });
                                                                                                                    const data = await res.json();
                                                                                                                    if (data.status === 'success') {
                                                                                                                        const idx = this.posts.findIndex(p => p.id === id);
                                                                                                                        this.posts[idx].post = data.post.post;
                                                                                                                        this.posts[idx].updated_at = data.post.updated_at;
                                                                                                                        this.posts[idx].updated_diff = 'just now';
                                                                                                                        this.posts[idx].is_updated = true;
                                                                                                                        this.editingId = null;
                                                                                                                    } else {
                                                                                                                        alert(data.message);
                                                                                                                    }
                                                                                                                } catch (e) { alert('Error saving'); }
                                                                                                            },
                                                                                                            async deletePost(id) {
                                                                                                                if (!confirm('Are you sure you want to PERMANENTLY delete this post? This cannot be undone.')) return;
                                                                                                                try {
                                                                                                                    const res = await fetch('/delete_post/' + id, {
                                                                                                                        method: 'POST',
                                                                                                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                                                                                                    });
                                                                                                                    const data = await res.json();
                                                                                                                    if (data.status === 'success') {
                                                                                                                        this.posts = this.posts.filter(p => p.id !== id);
                                                                                                                    } else {
                                                                                                                        alert(data.message);
                                                                                                                    }
                                                                                                                } catch (e) { alert('Error deleting'); }
                                                                                                            }
                                                                                                        }">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                        <h2 class="text-2xl font-black italic uppercase tracking-tighter text-pink-400">My Activity</h2>
                        <div class="flex items-center gap-3 bg-white/5 p-2 rounded-2xl border border-white/10">
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-500 ml-2">Sort
                                By:</span>
                            <select x-model="sortBy"
                                class="bg-transparent text-xs font-bold uppercase tracking-widest outline-none cursor-pointer pr-4">
                                <option value="newest">Newest</option>
                                <option value="oldest">Oldest</option>
                                <option value="type">Type</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <template x-for="post in sortedPosts" :key="post.id">
                            <div x-data="{ expanded: false }"
                                class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden transition-all duration-300 hover:border-pink-500/30 group">
                                <!-- Header / Collapsed View -->
                                <div @click="expanded = !expanded"
                                    class="p-4 cursor-pointer flex items-center justify-between hover:bg-white/5 transition">
                                    <div class="flex items-center gap-4">
                                        <div x-text="post.category"
                                            class="px-2 py-0.5 rounded bg-pink-500/20 text-pink-400 text-[9px] font-black uppercase tracking-widest">
                                        </div>
                                        <h4 class="text-sm font-bold text-gray-200 truncate max-w-[200px] md:max-w-md"
                                            x-text="post.post.substring(0, 100) + (post.post.length > 100 ? '...' : '')">
                                        </h4>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[10px] text-gray-500 font-mono italic"
                                            x-text="post.is_updated ? 'Updated ' + post.updated_diff : post.diff"></span>
                                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-300"
                                            :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Expanded Content -->
                                <div x-show="expanded" x-collapse x-cloak
                                    class="p-6 pt-0 border-t border-white/5 bg-black/20">
                                    <!-- Images -->
                                    <template x-if="post.images.length > 0">
                                        <div class="flex gap-2 overflow-x-auto py-4 scrollbar-hide">
                                            <template x-for="img in post.images">
                                                <img :src="'/' + img"
                                                    class="h-32 rounded-xl object-cover border border-white/10 shadow-lg">
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Text Content -->
                                    <div
                                        class="prose prose-invert max-w-none text-sm text-gray-300 leading-relaxed mb-6 italic mt-4">
                                        <template x-if="editingId !== post.id">
                                            <p x-text="post.post" class="whitespace-pre-wrap"></p>
                                        </template>
                                        <template x-if="editingId === post.id">
                                            <div class="space-y-4">
                                                <textarea x-model="editContent" rows="4"
                                                    class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 text-gray-200 focus:outline-none focus:border-pink-500 transition resize-none"></textarea>
                                                <div class="flex gap-2">
                                                    <button @click="savePost(post.id)"
                                                        class="px-6 py-2 bg-pink-600 hover:bg-pink-500 rounded-xl text-[10px] font-black uppercase tracking-widest transition">Save
                                                        Changes</button>
                                                    <button @click="editingId = null"
                                                        class="px-6 py-2 bg-white/5 hover:bg-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest transition">Cancel</button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Actions -->
                                    <div x-show="editingId !== post.id"
                                        class="flex flex-wrap gap-4 pt-4 border-t border-white/5">
                                        <button @click="editingId = post.id; editContent = post.post"
                                            class="px-4 py-2 bg-white/5 hover:bg-white/10 text-gray-300 rounded-xl text-[10px] font-black uppercase tracking-widest transition border border-white/10">Edit
                                            Content</button>
                                        <button @click="deletePost(post.id)"
                                            class="px-4 py-2 bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition border border-red-600/30">Delete
                                            Permanently</button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="sortedPosts.length === 0" class="animate-fade-in w-full">
                            <div
                                class="py-20 text-center bg-white/5 rounded-3xl border border-dashed border-white/10 flex flex-col items-center justify-center space-y-4">
                                <div class="w-12 h-12 bg-pink-600/10 rounded-2xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white font-black italic uppercase tracking-tighter text-base">No posts
                                        exists at the moment</p>
                                    <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em] mt-1">Ready to
                                        share your first festival moment?</p>
                                </div>
                                <a href="{{ url('share_zone') }}"
                                    class="mt-4 px-8 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl text-[10px] font-black uppercase tracking-widest transition active:scale-95">Go
                                    to Share Zone</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Penalties Section -->
            @if($isOwner || optional($viewer)->role === 'admin')
                <div x-show="tab === 'penalties'" x-cloak class="animate-fade-in-up space-y-6">
                    <h2 class="text-2xl font-black italic uppercase tracking-tighter text-red-500">History & Penalties</h2>

                    <div class="grid grid-cols-1 gap-4">
                        @forelse($penalties as $penalty)
                            <div class="bg-white/5 border border-white/10 p-6 rounded-3xl flex items-start gap-4 shadow-xl">
                                <div class="bg-red-500/20 p-3 rounded-2xl text-red-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-black uppercase tracking-widest text-red-500 text-[10px] mb-1 opacity-70">
                                        @if($penalty->target_type === 'post') Content Violation @else Account Violation @endif
                                    </h4>
                                    <h4 class="font-black uppercase tracking-widest text-red-500 text-sm italic">
                                        Result: {{ ucfirst($penalty->status) }}
                                    </h4>
                                    <p
                                        class="text-gray-300 text-sm italic mt-1 font-medium bg-black/20 p-4 rounded-xl border border-white/5">
                                        "{!! nl2br(e($penalty->admin_comment ?: $penalty->reason)) !!}"
                                    </p>
                                    <div class="mt-3 text-[9px] text-gray-500 font-bold uppercase tracking-widest">
                                        Issued {{ $penalty->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="py-20 text-center bg-white/5 rounded-3xl border border-dashed border-white/10 italic text-gray-500 uppercase tracking-widest font-bold">
                                Clear record. Stay legendary.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            <!-- My Messages Section -->
            @if($isOwner)
                <div x-show="tab === 'messages'" x-cloak class="animate-fade-in-up space-y-6">
                    <div class="flex flex-col gap-6">
                        <h2 class="text-2xl font-black italic uppercase tracking-tighter text-indigo-400">My
                            Conversations</h2>

                        <template x-if="threads.length === 0">
                            <div class="animate-fade-in">
                                <div
                                    class="bg-white/5 border border-white/10 rounded-3xl p-16 text-center flex flex-col items-center">
                                    <div
                                        class="w-20 h-20 bg-indigo-600/10 rounded-3xl flex items-center justify-center mb-6 border border-indigo-500/20">
                                        <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-black italic uppercase tracking-tighter text-white mb-2">Your
                                        inbox is quiet</h3>
                                    <p
                                        class="text-gray-500 text-xs font-black uppercase tracking-widest max-w-xs mx-auto leading-relaxed">
                                        Connect with others in the Share Zone or Missed Connections to start a conversation!
                                    </p>
                                </div>
                            </div>
                        </template>

                        <div class="grid grid-cols-1 gap-4">
                            <template x-for="thread in threads" :key="thread.partner.id">
                                <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden transition-all duration-500"
                                    :class="activeThreadId === thread.partner.id ? 'ring-2 ring-indigo-500/50 shadow-2xl shadow-indigo-500/10' : ''">

                                    <!-- Thread Header -->
                                    <div @click="activeThreadId = (activeThreadId === thread.partner.id ? null : thread.partner.id); if(activeThreadId) markRead(thread.partner.id)"
                                        class="p-6 flex items-center justify-between cursor-pointer hover:bg-white/5 transition">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <img :src="thread.partner.profile_image ? '/' + thread.partner.profile_image : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' + thread.partner.name"
                                                    class="w-12 h-12 rounded-2xl object-cover border border-white/10">
                                                <div class="absolute -bottom-1 -right-1 w-3 h-3 rounded-full border-2 border-black"
                                                    :class="thread.partner.last_seen_at && (new Date() - new Date(thread.partner.last_seen_at) < 120000) ? 'bg-green-500' : 'bg-red-500'">
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-black italic uppercase tracking-tight text-white"
                                                    x-text="thread.partner.name"></h4>
                                                <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest truncate max-w-[200px]"
                                                    x-text="thread.messages && thread.messages.length > 0 ? (thread.messages[thread.messages.length-1].message || 'Sent an image') : 'No messages'">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <template x-if="thread.unread_count > 0">
                                                <span
                                                    class="bg-red-600 text-white text-[10px] font-black px-2 py-1 rounded-full"
                                                    x-text="thread.unread_count + ' NEW'"></span>
                                            </template>
                                            <svg class="w-5 h-5 text-gray-600 transition-transform duration-300"
                                                :class="activeThreadId === thread.partner.id ? 'rotate-180' : ''"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Chat Content -->
                                    <div x-show="activeThreadId === thread.partner.id" x-collapse>
                                        <div class="px-6 pb-6 space-y-6">
                                            <div
                                                class="max-h-[400px] overflow-y-auto pr-2 space-y-4 custom-scrollbar flex flex-col">
                                                <template x-for="msg in thread.messages" :key="msg.id">
                                                    <div :class="msg.sender_id === thread.partner.id ? 'self-start' : 'self-end' "
                                                        class="max-w-[80%] group/msg relative">
                                                        <div :class="msg.sender_id === thread.partner.id ? 'bg-white/5 rounded-2xl rounded-tl-none' : 'bg-indigo-600 rounded-2xl rounded-tr-none shadow-lg shadow-indigo-600/20' "
                                                            class="p-4 border border-white/10">

                                                            <!-- Images -->
                                                            <template x-if="msg.images && msg.images.length > 0">
                                                                <div class="grid grid-cols-2 gap-2 mb-3">
                                                                    <template x-for="img in msg.images" :key="img">
                                                                        <img :src="'/' + img"
                                                                            class="w-full h-24 object-cover rounded-xl border border-white/10 cursor-pointer hover:scale-105 transition"
                                                                            @click="window.open('/' + img, '_blank')">
                                                                    </template>
                                                                </div>
                                                            </template>

                                                            <!-- Message text -->
                                                            <div x-show="editingMsgId !== msg.id">
                                                                <p class="text-sm text-white leading-relaxed"
                                                                    x-text="msg.message"></p>
                                                                <template x-if="msg.is_edited">
                                                                    <p class="text-[9px] text-white/40 italic mt-1"
                                                                        x-text="'Modified ' + new Date(msg.updated_at).toLocaleString()">
                                                                    </p>
                                                                </template>
                                                            </div>

                                                            <!-- Edit Input -->
                                                            <div x-show="editingMsgId === msg.id" class="space-y-2">
                                                                <textarea x-model="editContent"
                                                                    class="w-full bg-black/40 border border-white/20 rounded-xl p-2 text-sm text-white focus:outline-none focus:border-white transition"></textarea>
                                                                <div class="flex gap-2">
                                                                    <button @click="saveEdit(msg.id, thread.partner.id)"
                                                                        class="text-[10px] bg-white text-black font-bold uppercase px-3 py-1 rounded-lg">Save</button>
                                                                    <button @click="editingMsgId = null"
                                                                        class="text-[10px] text-gray-400 font-bold uppercase px-3 py-1">Cancel</button>
                                                                </div>
                                                            </div>

                                                            <!-- Controls (Own messages) -->
                                                            <template
                                                                x-if="msg.sender_id !== thread.partner.id && editingMsgId !== msg.id">
                                                                <div
                                                                    class="absolute -top-2 -left-2 flex gap-1 opacity-0 group-hover/msg:opacity-100 transition">
                                                                    <button
                                                                        @click="editingMsgId = msg.id; editContent = msg.message"
                                                                        class="bg-black border border-white/20 p-1.5 rounded-lg text-white hover:bg-white hover:text-black transition">
                                                                        <svg class="w-3 h-3" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path
                                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                            </path>
                                                                        </svg>
                                                                    </button>
                                                                    <button @click="deleteMsg(msg.id, thread.partner.id)"
                                                                        class="bg-black border border-white/20 p-1.5 rounded-lg text-red-500 hover:bg-red-500 hover:text-white transition">
                                                                        <svg class="w-3 h-3" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path
                                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                            </path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </template>
                                                        </div>
                                                        <span class="text-[8px] text-gray-600 mt-1 block"
                                                            x-text="new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) "></span>
                                                    </div>
                                                </template>
                                            </div>

                                            <!-- Reply Form -->
                                            <form :id="'reply_form_' + thread.partner.id"
                                                @submit.prevent="sendReply(thread.partner.id)" class="relative">
                                                <textarea name="message" required
                                                    class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 pr-32 text-gray-200 focus:outline-none focus:border-indigo-500 transition resize-none text-sm"
                                                    placeholder="Type a reply..."></textarea>
                                                <div class="absolute right-2 bottom-2 flex items-center gap-2">
                                                    <label
                                                        class="cursor-pointer p-2 hover:bg-white/5 rounded-xl transition text-gray-500 hover:text-indigo-400">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                        <input type="file" name="optConnectImg[]" multiple class="hidden"
                                                            accept="image/*">
                                                    </label>
                                                    <button type="submit"
                                                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-widest px-4 py-2 rounded-xl text-[10px] transition shadow-lg">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Invite Codes Section -->
            @if($isOwner)
                <div x-show="tab === 'invites'" x-cloak class="animate-fade-in-up space-y-6">
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
                        <h2 class="text-2xl font-black italic uppercase tracking-tighter text-amber-400 mb-6">Your Beta
                            Invites</h2>
                        <p class="text-gray-400 text-sm mb-8">Share these codes with 5 friends to invite them to the
                            FestConnection community! Each code can only be used once.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <template x-for="invite in generatedInvites" :key="invite.id">
                                <div class="bg-black/30 border border-white/10 p-5 rounded-2xl flex items-center justify-between group/invite transition-all duration-300"
                                    :class="invite.is_active ? 'opacity-40 grayscale pointer-events-none' : 'hover:border-amber-500/50 hover:bg-black/40'">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors"
                                            :class="invite.is_active ? 'bg-gray-500/10 text-gray-500' : 'bg-amber-500/10 text-amber-500'">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-black tracking-widest font-mono transition-all"
                                                :class="invite.is_active ? 'text-gray-500 line-through' : 'text-white'"
                                                x-text="invite.code"></h4>
                                            <p class="text-[10px] font-black uppercase tracking-widest"
                                                :class="invite.is_active ? 'text-red-500/70' : 'text-green-500'"
                                                x-text="invite.is_active ? 'Used' : 'Available'"></p>
                                        </div>
                                    </div>
                                    <button x-show="!invite.is_active" @click="copyCode(invite.code)"
                                        class="p-3 bg-white/5 hover:bg-amber-500 text-gray-400 hover:text-white rounded-xl transition-all shadow-lg active:scale-90">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 5H6a2 2 0 00-2 2v12a2 2 0 00-2 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                    </button>
                                    <div x-show="invite.is_active" class="px-3 text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Initiation Modal -->
            <div id="private_message_modal"
                class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
                <div
                    class="bg-gray-900 border border-white/10 rounded-3xl w-full max-w-lg p-8 shadow-2xl animate-fade-in-up">
                    <h2 class="text-2xl font-bold mb-6 text-pink-400 italic uppercase">Message <span
                            id="msg_target_name">User</span></h2>
                    <form id="private_message_form" class="space-y-6">
                        @csrf
                        <input type="hidden" name="receiver_id" id="msg_receiver_id">

                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Message</label>
                            <textarea name="message" rows="4" required
                                class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 text-gray-200 focus:outline-none focus:border-pink-500 transition resize-none"
                                placeholder="Write your message..."></textarea>
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Attach
                                Images (Optional)</label>
                            <input type="file" name="optConnectImg[]" multiple accept="image/*"
                                class="w-full bg-black/40 border border-white/10 rounded-xl p-2 text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-pink-600 file:text-white hover:file:bg-pink-500 transition">
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                class="flex-1 bg-pink-600 hover:bg-pink-500 py-4 rounded-2xl font-black uppercase tracking-widest transition text-sm shadow-xl">Send
                                Message</button>
                            <button type="button" onclick="closeMessageModal()"
                                class="px-8 bg-white/5 hover:bg-white/10 py-4 rounded-2xl font-bold uppercase tracking-widest transition text-gray-400 text-sm">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            let isEditMode = false;
            const selectedGenres = new Set({!! json_encode((array) $user->genres) !!});

            function toggleEditMode() {
                isEditMode = !isEditMode;
                if (!isEditMode) {
                    window.dispatchEvent(new CustomEvent('reset-password-lock'));
                }
                document.getElementById('profile_form').classList.toggle('hidden', !isEditMode);
                document.getElementById('edit_btn').classList.toggle('bg-white/10', isEditMode);
                document.querySelectorAll('.lg\\:col-span-2 > div').forEach(el => {
                    if (el.id !== 'profile_form') el.classList.toggle('hidden', isEditMode);
                });
            }

            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('profile_form');
                const imgInput = document.getElementById('img_upload');
                const profileDisplay = document.getElementById('profile_display');

                // Image Preview
                imgInput?.addEventListener('change', async (e) => {
                    const file = e.target.files[0];
                    if (!file) return;

                    // Direct upload
                    const formData = new FormData();
                    formData.append('profile_image', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    try {
                        const res = await fetch('/profile/update', {
                            method: 'POST',
                            body: formData
                        });
                        const data = await res.json();
                        if (data.status === 'success') {
                            profileDisplay.src = `/${data.user.profile_image}?v=${Date.now()}`;
                            // Update header if applicable
                        }
                    } catch (err) { console.error(err); }
                });

                // Genre Toggles
                document.querySelectorAll('.genre-chip').forEach(chip => {
                    chip.addEventListener('click', () => {
                        const g = chip.dataset.genre;
                        if (selectedGenres.has(g)) {
                            selectedGenres.delete(g);
                            chip.classList.remove('bg-purple-600', 'border-purple-500', 'bg-pink-600', 'border-pink-500', 'text-white');
                            chip.classList.add('bg-white/5', 'text-gray-500');
                        } else {
                            selectedGenres.add(g);
                            const isEdm = chip.parentElement.id === 'edm_genres_wrap';
                            chip.classList.remove('bg-white/5', 'text-gray-500');
                            if (isEdm) chip.classList.add('bg-purple-600', 'border-purple-500', 'text-white');
                            else chip.classList.add('bg-pink-600', 'border-pink-500', 'text-white');
                        }
                    });
                });

                // Form Submission
                form?.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const btn = form.querySelector('button[type="submit"]');
                    btn.innerText = "SAVING...";
                    btn.disabled = true;

                    const formData = new FormData(form);
                    formData.append('genres', JSON.stringify(Array.from(selectedGenres)));
                    formData.append('user_id', {{ $user->id }});

                    try {
                        const res = await fetch('/profile/update', {
                            method: 'POST',
                            body: formData,
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        });
                        const data = await res.json();
                        if (data.status === 'success') {
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    } catch (err) { alert("An error occurred"); }
                    finally {
                        btn.innerText = "SAVE PROFILE";
                        btn.disabled = false;
                    }
                });

                // Presence Polling (for Owner)
                @if($isOwner)
                    const updatePresence = async () => {
                        try {
                            await fetch('/update_presence', {
                                method: 'POST',
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                            });
                        } catch (e) { }
                    };
                    updatePresence();
                    setInterval(updatePresence, 30000);
                @endif

                // --- Messaging Logic ---
                window.initiateMessage = (userId, userName) => {
                    document.getElementById('msg_receiver_id').value = userId;
                    document.getElementById('msg_target_name').innerText = userName;
                    document.getElementById('private_message_modal').classList.remove('hidden');
                };

                window.closeMessageModal = () => {
                    document.getElementById('private_message_modal').classList.add('hidden');
                    document.getElementById('private_message_form').reset();
                };

                document.getElementById('private_message_form')?.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const form = e.target;
                    const btn = form.querySelector('button[type="submit"]');
                    btn.disabled = true;
                    btn.innerText = "SENDING...";

                    const formData = new FormData(form);

                    try {
                        const res = await fetch('/send_message', {
                            method: 'POST',
                            body: formData,
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        });
                        const data = await res.json();
                        if (data.status === 'success') {
                            alert('Message sent successfully!');
                            closeMessageModal();
                            @if($isOwner)
                                // Dispatch event to Alpine correctly
                                window.dispatchEvent(new CustomEvent('refresh-threads'));
                            @endif
                        } else {
                            alert(data.message || 'Failed to send message.');
                        }
                    } catch (err) {
                        console.error(err);
                        alert("Error sending message.");
                    } finally {
                        btn.disabled = false;
                        btn.innerText = "SEND MESSAGE";
                    }
                });
            });
        </script>

        <!-- Flag Modal (Admin Only) -->
        <div id="mod_flag_modal"
            class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
            <div
                class="bg-gray-900 border border-white/10 rounded-3xl w-full max-w-lg p-8 shadow-2xl animate-fade-in-up">
                <h2 class="text-2xl font-bold mb-6 text-pink-400 italic uppercase">Flag User</h2>
                <form id="mod_flag_form" class="space-y-6">
                    @csrf
                    <input type="hidden" name="target_id" id="flag_target_id">
                    <input type="hidden" name="target_type" id="flag_target_type">

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Flag
                            Type</label>
                        <select name="type"
                            class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:border-pink-500 outline-none">
                            <option value="warning">Potential Violation</option>
                            <option value="bad">Bad Conduct / Spam</option>
                            <option value="nudity">Nudity / NSFW</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Reason
                            (Visible to Admin)</label>
                        <textarea name="reason" rows="4" required
                            class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 text-gray-200 focus:outline-none focus:border-pink-500 transition resize-none"
                            placeholder="Reason for this flag..."></textarea>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-pink-600 hover:bg-pink-500 py-4 rounded-2xl font-black uppercase tracking-widest transition text-sm shadow-xl">Submit
                            Flag</button>
                        <button type="button" onclick="closeModFlagModal()"
                            class="px-8 bg-white/5 hover:bg-white/10 py-4 rounded-2xl font-bold uppercase tracking-widest transition text-gray-400 text-sm">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            window.openModFlagModal = (id, type) => {
                document.getElementById('flag_target_id').value = id;
                document.getElementById('flag_target_type').value = type;
                document.getElementById('mod_flag_modal').classList.remove('hidden');
            };

            window.closeModFlagModal = () => {
                document.getElementById('mod_flag_modal').classList.add('hidden');
            };

            document.getElementById('mod_flag_form')?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                try {
                    const res = await fetch('/flag', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await res.json();
                    if (data.status === 'success') {
                        alert('User flagged for admin review.');
                        closeModFlagModal();
                    } else {
                        alert(data.message);
                    }
                } catch (err) { alert("Error flagging user"); }
            });
        </script>

        <style>
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fade-in-up 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }

            @keyframes pulse-subtle {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.8;
                }
            }

            .animate-pulse-subtle {
                animation: pulse-subtle 4s ease-in-out infinite;
            }
        </style>
        <!-- Welcome Modal -->
        <div x-show="showWelcomeModal" x-cloak
            class="fixed inset-0 z-[200] flex items-center justify-center bg-black/95 backdrop-blur-xl p-4">
            <div
                class="bg-gray-900 border border-white/10 rounded-3xl w-full max-w-xl p-10 shadow-2xl animate-fade-in-up relative overflow-hidden">
                <!-- Decor -->
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-purple-600/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-pink-600/20 rounded-full blur-3xl"></div>

                <div class="relative z-10 text-center">
                    <div
                        class="w-100 h-20 bg-gradient-to-tr from-purple-600 to-pink-600 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-2xl transform rotate-3">
                        <img src="{{ asset('img/logo_email.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>

                    <h2 class="text-4xl font-black italic uppercase tracking-tighter text-white mb-4">Welcome to the
                        Fam!</h2>
                    <p class="text-purple-400 font-bold uppercase tracking-widest text-xs mb-8">You're officially
                        part
                        of the FestConnection Beta</p>

                    <div class="bg-white/5 border border-white/10 p-6 rounded-2xl mb-8 text-left">
                        <p class="text-gray-300 leading-relaxed mb-4">We're stoked to have you here! As a beta
                            member,
                            you have <span class="text-white font-bold">5 exclusive invite codes</span> to bring
                            your
                            festival squad onto the platform.</p>
                        <p class="text-gray-300 leading-relaxed">You can find your codes in the <span
                                class="text-amber-400 font-bold">Invite Codes</span> tab right here on your profile
                            page. Copy them and send them over to your friends!</p>
                    </div>

                    <button @click="markWelcomeSeen()"
                        class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 py-4 rounded-2xl font-black uppercase tracking-widest transition shadow-xl shadow-purple-600/20 active:scale-95 text-white">
                        Let's Get Started
                    </button>
                </div>
            </div>
        </div>

        @stop
        ```