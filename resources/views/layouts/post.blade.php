<div class="flex flex-col">
    <a href="/reconnections" class="text-xl text-gray-600 dark:text-gray-400 hover:text-red-400 p-10 m-2 border-solid rounded-md border-2 hover:bg-slate-900/80">
        <div class="flex flex-row text-xl text-gray-600 dark:text-gray-400 hover:text-red-400 p-5 m-2 hover:bg-slate-900/80">
            <div>
                <img src=@yield('post-image') alt="Post Image" class="w-48 h-48">
            </div>
            <div>
                <h3 class="text-2xl font-bold">Festival: @yield('festival')</h3>
                <h3 class="text-2xl font-bold">@yield('name') is looking for this missed connection:</h3>
                <p class="text-lg">@yield('description')</p>
        </div>
    </a>
</div>