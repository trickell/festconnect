@extends('layouts.master')

@section('title', 'Fest Connection || User Profile')

@section('content')
<div class="relative min-h-screen py-24 flex flex-col items-center bg-black text-white overflow-hidden">
    <!-- Background Decor -->
    <!-- Video Background -->
    <x-video-background source="img/video/profile_bg.mp4" />
    <div
        class="absolute top-0 left-0 w-full h-[500px] bg-gradient-to-b from-purple-900/20 to-transparent pointer-events-none">
    </div>
    <div
        class="absolute -top-24 -left-24 w-96 h-96 bg-pink-600/10 rounded-full blur-[120px] pointer-events-none animate-pulse">
    </div>
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
                    $isOnline = $lastSeen && now()->diffInMinutes($lastSeen) < 1;
                    $statusColor = $isOnline ? 'bg-green-500 shadow-[0_0_15px_rgba(34,197,94,0.5)]' : 'bg-red-500 shadow-[0_0_15px_rgba(239,68,68,0.5)]';
                @endphp
                <div id="status_indicator"
                    class="absolute -bottom-2 -right-2 {{ $statusColor }} w-6 h-6 rounded-full border-4 border-black transition-colors duration-500">
                </div>
            </div>

            <div class="flex-grow text-center md:text-left">
                <h1
                    class="text-4xl md:text-6xl font-black italic uppercase tracking-tighter mb-2 bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-white/40">
                    {{ $user->name }}
                </h1>
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

            @if($isOwner)
                <button onclick="toggleEditMode()" id="edit_btn"
                    class="px-8 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl font-bold transition flex items-center gap-2 text-sm uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Profile
                </button>
            @endif
        </div>

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
                        <h3 class="text-xl font-bold uppercase tracking-widest mb-6 text-pink-400 flex items-center gap-3">
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

                <!-- Edit Form (Hidden by default) -->
                @if($isOwner)
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
                                        class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Change
                                        Password</label>
                                    <input type="password" name="password" placeholder="••••••••"
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-purple-500 transition">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">About
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
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Favorite
                                    Genres</label>
                                <div class="space-y-6">
                                    <div>
                                        <h4 class="text-[10px] font-bold text-purple-400 uppercase tracking-[0.2em] mb-3">
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
                                        <h4 class="text-[10px] font-bold text-pink-400 uppercase tracking-[0.2em] mb-3">Rock
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
                    <h3 class="text-xs font-bold uppercase tracking-[0.3em] mb-6 text-gray-400">Community Stats</h3>
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
                            <h4 class="text-[10px] font-bold uppercase tracking-widest mb-4 text-gray-400">My Genres</h4>
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
</div>

<script>
    let isEditMode = false;
    const selectedGenres = new Set({!! json_encode((array) $user->genres) !!});

    function toggleEditMode() {
        isEditMode = !isEditMode;
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

            try {
                const res = await fetch('/profile/update', {
                    method: 'POST',
                    body: formData
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
            } catch (e) {}
        };
        updatePresence();
        setInterval(updatePresence, 20000);
        @endif
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
</style>
@stop