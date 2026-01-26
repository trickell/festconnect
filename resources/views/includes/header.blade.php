<header
    class="w-full z-50 bg-violet-950/80 backdrop-blur-md border-b border-white/10 sticky top-0 transition-all duration-300">
    <nav class="w-full px-4 md:px-8 py-3 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}"
            class="text-xl md:text-2xl font-bold text-white tracking-wider hover:text-purple-300 transition shrink-0 mr-4">
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

            <!-- User/Login -->
            @if(session('user'))
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

        <!-- Auth Buttons (Desktop) -->
        <div class="hidden md:flex items-center space-x-4">
            @if(session('user'))
                <span class="text-gray-300 text-sm">Hi, {{ session('user')->name ?? 'User' }}</span>
                <a href="{{ url('/logout') }}"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-full text-sm font-semibold transition">Logout</a>
            @else
                <a href="{{ url('/login') }}"
                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-full text-sm font-semibold transition">Login</a>
            @endif
        </div>
    </nav>
</header>