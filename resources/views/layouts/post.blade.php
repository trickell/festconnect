<div
    class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl overflow-hidden hover:bg-white/10 transition duration-300">
    <a href="/reconnections?post_id=@yield('post-id')" class="block">
        <div class="relative h-48 w-full group">
            <img src="@yield('post-image')" alt="Post Image"
                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            <div
                class="absolute top-2 right-2 bg-purple-600/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-white uppercase tracking-wider">
                @yield('festival')</div>
        </div>
        <div class="p-5">
            <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">@yield('name') is looking...</h3>
            <p class="text-gray-300 text-sm line-clamp-3 leading-relaxed">@yield('description')</p>
            <div class="mt-4 pt-4 border-t border-white/10 flex justify-between items-center text-xs">
                <span class="text-purple-300 font-medium group-hover:text-purple-200 transition">Read Connection</span>
                <span class="text-gray-500">View Details &rarr;</span>
            </div>
        </div>
    </a>
</div>