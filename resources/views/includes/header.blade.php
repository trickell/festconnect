<header x-data="{ mobileMenuOpen: false }"
    class="w-full z-50 bg-violet-950/80 backdrop-blur-md border-b border-white/10 sticky top-0 transition-all duration-300">
    <nav class="w-full px-4 md:px-8 py-3 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}"
            class="flex text-2xl md:text-3xl font-bold text-white tracking-wider hover:text-purple-300 transition">
            Fest<span class="text-purple-400">Connection</span>
        </a>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex space-x-6 items-center flex-1 justify-center">
            <li><a href="{{ url('/') }}"
                    class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('/') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">Home</a>
            </li>
            <li>
                <div class="group relative">
                    <a href="{{ url('missed_connections') }}"
                        class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('missed_connections') || Request::is('reconnections') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">Missed
                        Connections</a>
                    <div
                        class="absolute z-10 w-48 bg-violet-950/80 backdrop-blur-md rounded-md shadow-lg py-3 mt-2 hidden group-hover:block border border-white/5 left-1/2 -translate-x-1/2">
                        <div class="flex flex-col">
                            <a href="{{ url('reconnections') }}"
                                class="text-gray-300 hover:text-white transition px-4 py-2 text-sm hover:bg-white/10">Reconnections</a>
                            <a href="{{ url('share_zone') }}"
                                class="text-gray-300 hover:text-white transition px-4 py-2 text-sm hover:bg-white/10">Share
                                Zone</a>
                        </div>
                    </div>
                </div>
            </li>
            <li><a href="{{ url('about') }}"
                    class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('about') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">About</a>
            </li>
            <li><a href="{{ url('contact') }}"
                    class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('contact') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">Contact</a>
            </li>
        </ul>

        <!-- Right Side: Notifications & Profile -->
        <div class="flex items-center gap-4">
            @if(session('user'))
                <!-- Notifications -->
                <div class="relative" id="notification_dropdown_wrapper">
                    <button id="notification_bell" class="p-2 text-gray-300 hover:text-white transition relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span id="notif_badge"
                            class="absolute top-1 right-1 bg-red-600 text-[10px] font-bold text-white px-1.5 py-0.5 rounded-full shadow-[0_0_10px_rgba(220,38,38,0.5)] hidden">0</span>
                    </button>
                    <!-- Dropdown -->
                    <div id="notif_dropdown"
                        class="absolute right-0 top-full mt-2 w-72 bg-gray-900/95 backdrop-blur-xl border border-white/10 rounded-xl shadow-2xl py-2 hidden z-[60]">
                        <div class="px-4 py-2 border-b border-white/5 flex justify-between items-center">
                            <span
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">Notifications</span>
                            <button onclick="markAllRead()"
                                class="text-[9px] text-purple-400 hover:text-purple-300 font-black uppercase tracking-widest transition">Mark
                                All Read</button>
                        </div>
                        <div id="notif_list" class="max-h-80 overflow-y-auto custom-scrollbar">
                            <p
                                class="text-center py-6 text-[10px] text-gray-500 font-bold uppercase tracking-widest opacity-50 italic">
                                No new notifications</p>
                        </div>
                    </div>
                </div>

                <!-- User Profile -->
                <a href="{{ url('/profile/' . (optional(session('user'))->name ?? '')) }}"
                    class="hidden md:flex items-center space-x-3 group">
                    <span class="text-gray-300 text-sm group-hover:text-white transition">Hi,
                        {{ optional(session('user'))->name ?? 'User' }}</span>
                    <div
                        class="w-8 h-8 rounded-full overflow-hidden border border-white/10 group-hover:border-purple-500 transition shadow-lg">
                        <img src="{{ optional(session('user'))->profile_image ? asset(optional(session('user'))->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(optional(session('user'))->name ?? '') . '&background=6366f1&color=fff&size=64' }}"
                            class="w-full h-full object-cover">
                    </div>
                </a>

                <!-- Mobile User Icon -->
                <a href="{{ url('/profile/' . (optional(session('user'))->name ?? '')) }}"
                    class="md:hidden p-2 text-gray-400 hover:text-white transition">
                    <img src="{{ optional(session('user'))->profile_image ? asset(optional(session('user'))->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(optional(session('user'))->name ?? '') . '&background=6366f1&color=fff&size=64' }}"
                        class="w-6 h-6 rounded-full object-cover border border-white/10">
                </a>

                <a href="{{ url('/logout') }}"
                    class="hidden md:inline-block px-5 py-2 bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white border border-red-500/20 rounded-full text-xs font-black uppercase tracking-widest transition shadow-lg">Logout</a>
            @else
                <a href="{{ url('/login') }}"
                    class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-full text-xs font-black uppercase tracking-widest transition shadow-[0_0_15px_rgba(168,85,247,0.4)]">Login</a>
            @endif

            <!-- Mobile Menu Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden p-2 text-gray-400 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7" />
                    <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-full" x-cloak style="display: none;"
        class="md:hidden absolute top-full left-0 w-full bg-violet-950/95 backdrop-blur-xl border-b border-white/10 shadow-2xl z-40 overflow-hidden">
        <ul class="flex flex-col p-6 space-y-4">
            <li>
                <a href="{{ url('/') }}" @click="mobileMenuOpen = false"
                    class="flex items-center gap-4 text-gray-300 hover:text-white transition p-3 rounded-xl hover:bg-white/5 {{ Request::is('/') ? 'text-white bg-white/10' : '' }}">
                    <i class="fa fa-home w-5 text-purple-400"></i>
                    <span class="font-bold uppercase tracking-widest text-xs">Home</span>
                </a>
            </li>
            <li>
                <a href="{{ url('missed_connections') }}" @click="mobileMenuOpen = false"
                    class="flex items-center gap-4 text-gray-300 hover:text-white transition p-3 rounded-xl hover:bg-white/5 {{ Request::is('missed_connections') ? 'text-white bg-white/10' : '' }}">
                    <i class="fa fa-heart w-5 text-pink-400"></i>
                    <span class="font-bold uppercase tracking-widest text-xs">Missed Connections</span>
                </a>
            </li>
            <li>
                <a href="{{ url('reconnections') }}" @click="mobileMenuOpen = false"
                    class="flex items-center gap-4 text-gray-300 hover:text-white transition p-3 rounded-xl hover:bg-white/5 {{ Request::is('reconnections') ? 'text-white bg-white/10' : '' }}">
                    <i class="fa fa-users w-5 text-indigo-400"></i>
                    <span class="font-bold uppercase tracking-widest text-xs">Reconnections</span>
                </a>
            </li>
            <li>
                <a href="{{ url('share_zone') }}" @click="mobileMenuOpen = false"
                    class="flex items-center gap-4 text-gray-300 hover:text-white transition p-3 rounded-xl hover:bg-white/5 {{ Request::is('share_zone') ? 'text-white bg-white/10' : '' }}">
                    <i class="fa fa-camera w-5 text-blue-400"></i>
                    <span class="font-bold uppercase tracking-widest text-xs">Share Zone</span>
                </a>
            </li>
            <li class="border-t border-white/5 pt-4">
                <a href="{{ url('about') }}" @click="mobileMenuOpen = false"
                    class="flex items-center gap-4 text-gray-300 hover:text-white transition p-3 rounded-xl hover:bg-white/5 {{ Request::is('about') ? 'text-white bg-white/10' : '' }}">
                    <i class="fa fa-info-circle w-5 text-gray-400"></i>
                    <span class="font-bold uppercase tracking-widest text-xs">About</span>
                </a>
            </li>
            <li>
                <a href="{{ url('contact') }}" @click="mobileMenuOpen = false"
                    class="flex items-center gap-4 text-gray-300 hover:text-white transition p-3 rounded-xl hover:bg-white/5 {{ Request::is('contact') ? 'text-white bg-white/10' : '' }}">
                    <i class="fa fa-envelope w-5 text-gray-400"></i>
                    <span class="font-bold uppercase tracking-widest text-xs">Contact</span>
                </a>
            </li>
            @if(session('user'))
                <li class="pt-4">
                    <a href="{{ url('/logout') }}"
                        class="flex items-center justify-center gap-2 w-full py-4 bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white rounded-xl font-black uppercase tracking-widest text-[10px] transition border border-red-500/20">
                        <i class="fa fa-sign-out"></i>
                        Logout
                    </a>
                </li>
            @endif
        </ul>
    </div>
</header>

@if(session('user'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bell = document.getElementById('notification_bell');
            const dropdown = document.getElementById('notif_dropdown');
            const badge = document.getElementById('notif_badge');
            const list = document.getElementById('notif_list');
            let isDropdownOpen = false;

            const fetchNotifications = async () => {
                try {
                    const res = await fetch('/get_notifications');
                    const data = await res.json();
                    updateUI(data);
                } catch (e) { console.error("Notif error:", e); }
            };

            const updateUI = (notifications) => {
                const count = notifications.length;
                if (count > 0) {
                    badge.innerText = count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }

                if (notifications.length === 0) {
                    list.innerHTML = '<p class="text-center py-6 text-[10px] text-gray-500 font-bold uppercase tracking-widest opacity-50 italic">No new notifications</p>';
                    return;
                }

                list.innerHTML = notifications.map(n => {
                    const data = n.data || {};
                    let actor = 'System';
                    let msg = 'New activity detected';
                    let icon = '🔔';

                    if (n.type === 'message') {
                        actor = data.sender_name || 'Someone';
                        msg = `messaged you: "${data.message_snippet}"`;
                        icon = '💬';
                    } else if (n.type === 'moderation_action') {
                        actor = 'Moderator';
                        msg = data.message || 'Action taken on your account';
                        icon = '⚠️';
                    } else {
                        actor = data.tagged_by || data.reply_by || data.comment_by || 'System';
                        msg = data.message || 'New activity detected';
                    }

                    return `
                                                    <div class="px-4 py-4 hover:bg-white/5 border-b border-white/5 transition cursor-pointer group" onclick="handleNotifClick(${JSON.stringify(data).replace(/"/g, '&quot;')})">
                                                        <div class="flex gap-3 items-start">
                                                            <span class="text-sm mt-0.5">${icon}</span>
                                                            <div class="flex-grow">
                                                                <p class="text-[11px] text-gray-200 leading-snug">
                                                                    <span class="font-black text-purple-400 uppercase tracking-tighter">${actor}</span> 
                                                                    ${msg}
                                                                </p>
                                                                <span class="text-[8px] text-gray-500 italic mt-1 block uppercase font-black tracking-[0.1em] opacity-60">
                                                                    ${new Date(n.created_at).toLocaleDateString([], { month: 'short', day: 'numeric' })} @ ${new Date(n.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                `;
                }).join('');
            };

            window.handleNotifClick = (data) => {
                if (data.post_id) {
                    window.location.href = `/share_zone?post=${data.post_id}`;
                } else if (data.message_id) {
                    const userName = "{{ is_object(session('user')) ? session('user')->getAttribute('name') : (session('user')['name'] ?? '') }}";
                    window.location.href = `/profile/${encodeURIComponent(userName)}?tab=messages`;
                }
            };

            window.markAllRead = async () => {
                try {
                    await fetch('/mark_notifications_read', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    fetchNotifications();
                } catch (e) { console.error(e); }
            };

            bell.addEventListener('click', (e) => {
                e.stopPropagation();
                isDropdownOpen = !isDropdownOpen;
                dropdown.classList.toggle('hidden', !isDropdownOpen);
            });

            document.addEventListener('click', () => {
                isDropdownOpen = false;
                dropdown.classList.add('hidden');
            });

            dropdown.addEventListener('click', (e) => e.stopPropagation());

            fetchNotifications();
            setInterval(fetchNotifications, 15000);
        });
    </script>
@endif