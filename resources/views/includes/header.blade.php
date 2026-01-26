<header
    class="w-full z-50 bg-violet-950/80 backdrop-blur-md border-b border-white/10 sticky top-0 transition-all duration-300">
    <nav class="w-full px-4 md:px-8 py-3 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex text-2xl md:text-3xl font-bold text-white tracking-wider 
            hover:text-purple-300 transition ">
            Fest<span class="text-purple-400">Connect</span>
        </a>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex space-x-6 items-center flex-1 justify-center">
            <li>
                <a href="{{ url('/') }}"
                    class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('/') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">Home</a>
            </li>
            <li>

                <div class="group">
                    <a href="{{ url('missed_connections') }}"
                        class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('missed_connections') || Request::is('reconnections') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">Missed
                        Connections
                    </a>
                    <div class="absolute z-10 w-48 bg-violet-950/80 backdrop-blur-md 
                    rounded-md shadow-lg py-3 mt-2 hidden group-hover:block">
                        <div class="flex flex-col">
                            <a href="{{ url('reconnections') }}"
                                class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('reconnections') || Request::is('reconnections') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">Reconnections</a>
                            <a href="{{ url('share_zone') }}"
                                class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('share_zone') || Request::is('reconnections') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">Share
                                Zone</a>
                        </div>
                    </div>
                </div>

            </li>
            <li>
                <a href="{{ url('about') }}"
                    class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('about') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">About</a>
            </li>
            <li>
                <a href="{{ url('contact') }}"
                    class="text-gray-300 hover:text-white transition px-3 py-2 rounded-md {{ Request::is('contact') ? 'text-white bg-white/10 shadow-[0_0_10px_rgba(168,85,247,0.3)]' : '' }}">Contact</a>
            </li>
        </ul>

        <!-- Mobile Menu (Icons) -->
        <div class="flex md:hidden items-center justify-end flex-wrap gap-2">

            <!-- Home -->
            <a href="{{ url('/') }}"
                class="group flex items-center p-2 rounded-full transition-all duration-300 ease-in-out {{ Request::is('/') ? 'bg-purple-600 shadow-[0_0_15px_rgba(168,85,247,0.6)] text-white' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span
                    class="max-w-0 overflow-hidden whitespace-nowrap group-active:max-w-xs group-hover:max-w-xs group-hover:ml-2 transition-all duration-300 text-sm font-medium">Home</span>
            </a>

            <!-- Missed Connections -->
            <a href="{{ url('missed_connections') }}"
                class="group flex items-center p-2 rounded-full transition-all duration-300 ease-in-out {{ Request::is('missed_connections') || Request::is('reconnections') ? 'bg-purple-600 shadow-[0_0_15px_rgba(168,85,247,0.6)] text-white' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span
                    class="max-w-0 overflow-hidden whitespace-nowrap group-active:max-w-xs group-hover:max-w-xs group-hover:ml-2 transition-all duration-300 text-sm font-medium">Connect</span>
            </a>

            <!-- About -->
            <a href="{{ url('about') }}"
                class="group flex items-center p-2 rounded-full transition-all duration-300 ease-in-out {{ Request::is('about') ? 'bg-purple-600 shadow-[0_0_15px_rgba(168,85,247,0.6)] text-white' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span
                    class="max-w-0 overflow-hidden whitespace-nowrap group-active:max-w-xs group-hover:max-w-xs group-hover:ml-2 transition-all duration-300 text-sm font-medium">About</span>
            </a>

            <!-- Contact -->
            <a href="{{ url('contact') }}"
                class="group flex items-center p-2 rounded-full transition-all duration-300 ease-in-out {{ Request::is('contact') ? 'bg-purple-600 shadow-[0_0_15px_rgba(168,85,247,0.6)] text-white' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span
                    class="max-w-0 overflow-hidden whitespace-nowrap group-active:max-w-xs group-hover:max-w-xs group-hover:ml-2 transition-all duration-300 text-sm font-medium">Contact</span>
            </a>

            <!-- Notifications (Mobile) -->
            <!-- @if(session('user'))
                <button id="mobile_notif_bell" class="p-2 text-gray-400 hover:text-white transition relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span id="mobile_notif_badge"
                        class="absolute top-1 right-1 bg-red-600 text-[10px] font-bold text-white px-1.5 py-0.5 rounded-full hidden">0</span>
                </button>
            @endif -->

            <!-- User/Login -->
            @if(session('user'))
                <a href="{{ url('/profile/' . (optional(session('user'))->name ?? '')) }}"
                    class="group flex items-center p-2 rounded-full transition-all duration-300 ease-in-out text-gray-400 hover:bg-white/10 hover:text-white">
                    <img src="{{ optional(session('user'))->profile_image ? asset(optional(session('user'))->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(optional(session('user'))->name ?? '') . '&background=6366f1&color=fff&size=64' }}"
                        class="w-6 h-6 rounded-full object-cover">
                </a>
                <a href="{{ url('/logout') }}"
                    class="group flex items-center p-2 rounded-full transition-all duration-300 ease-in-out text-red-400 hover:bg-red-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </a>
            @else
                <a href="{{ url('/login') }}"
                    class="group flex items-center p-2 rounded-full transition-all duration-300 ease-in-out text-gray-400 hover:bg-white/10 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </a>
            @endif
        </div>

        <!-- Notifications (Desktop) -->
        @if(session('user'))
            <div class="relative group" id="notification_dropdown_wrapper">
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
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Notifications</span>
                        <button onclick="markAllRead()"
                            class="text-[10px] text-purple-400 hover:text-purple-300 font-bold uppercase tracking-widest">Mark
                            All Read</button>
                    </div>
                    <div id="notif_list" class="max-h-80 overflow-y-auto custom-scrollbar">
                        <p class="text-center py-4 text-xs text-gray-500">No new notifications</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- User/Login (Desktop) -->
        <div class="hidden md:flex items-center space-x-4">
            @if(session('user'))
                <a href="{{ url('/profile/' . (optional(session('user'))->name ?? '')) }}"
                    class="flex items-center space-x-3 group">
                    <span class="text-gray-300 text-sm group-hover:text-white transition">Hi,
                        {{ optional(session('user'))->name ?? 'User' }}</span>
                    <div
                        class="w-8 h-8 rounded-full overflow-hidden border border-white/10 group-hover:border-purple-500 transition">
                        <img src="{{ optional(session('user'))->profile_image ? asset(optional(session('user'))->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(optional(session('user'))->name ?? '') . '&background=6366f1&color=fff&size=64' }}"
                            class="w-full h-full object-cover">
                    </div>
                </a>
                <a href="{{ url('/logout') }}"
                    class="px-4 py-2 bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white border border-red-600/30 rounded-full text-sm font-semibold transition">Logout</a>
            @else
                <a href="{{ url('/login') }}"
                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-full text-sm font-semibold transition">Login</a>
            @endif
        </div>
    </nav>
</header>

@if(session('user'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bell = document.getElementById('notification_bell');
            const dropdown = document.getElementById('notif_dropdown');
            const badge = document.getElementById('notif_badge');
            const mobileBadge = document.getElementById('mobile_notif_badge');
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
                    mobileBadge.innerText = count;
                    mobileBadge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                    mobileBadge.classList.add('hidden');
                }

                if (notifications.length === 0) {
                    list.innerHTML = '<p class="text-center py-4 text-xs text-gray-500">No new notifications</p>';
                    return;
                }

                list.innerHTML = notifications.map(n => `
                                                                            <div class="px-4 py-3 hover:bg-white/5 border-b border-white/5 transition cursor-pointer" onclick="handleNotifClick(${JSON.stringify(n.data).replace(/"/g, '&quot;')})">
                                                                                <p class="text-xs text-gray-200">
                                                                                    <span class="font-bold text-purple-400">${n.data.tagged_by || n.data.reply_by || n.data.comment_by || 'Someone'}</span> 
                                                                                    ${n.data.message}
                                                                                </p>
                                                                                <span class="text-[10px] text-gray-500 italic">${new Date(n.created_at).toLocaleString([], { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</span>
                                                                            </div>
                                                                        `).join('');
            };

            window.handleNotifClick = (data) => {
                // Redirect to post
                if (data.post_id) {
                    window.location.href = `/share_zone?post=${data.post_id}`;
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

            // Polling
            fetchNotifications();
            setInterval(fetchNotifications, 10000);
        });
    </script>
@endif