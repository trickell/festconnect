
<header class="justify-center flex-col">
    <nav class="text-white-500 text-center flex flex-row z-0">
        <ul class="flex flex-row mx-auto z-0">
            <li class="p-5 m-2 text-slate-500 bg-violet-950/50 text-xl hover:text-slate-200 hover:bg-violet-900/80 hover:border-1 hover:border-violet-500 hover:rounded-sm"><a htext-slate-200 "><a href="{{ url('/') }}">Home</a></li>
            <li class="p-5 m-2 text-slate-500 bg-violet-950/50 text-xl hover:text-slate-200 hover:bg-violet-900/80 hover:border-1 hover:border-violet-500 hover:rounded-sm"><a href="{{ url('missed_connections') }}">Missed Connections</a></li>
            <li class="p-5 m-2 text-slate-500 bg-violet-950/50 text-xl hover:text-slate-200 hover:bg-violet-900/80 hover:border-1 hover:border-violet-500 hover:rounded-sm"><a href="{{ url('about') }}">About</a></li>
            <li class="p-5 m-2 text-slate-500 bg-violet-950/50 text-xl hover:text-slate-200 hover:bg-violet-900/80 hover:border-1 hover:border-violet-500 hover:rounded-sm"><a href="url('contact') }}">Contact a Moderator</a></li>

            <li data-id="loginTrue" class="justify-right m-2 p-5 ml-20 text-slate-500 bg-sky-950/50 text-xl hover:text-slate-200 hover:bg-sky-800/80 hover:border-1 hover:border-sky-500 hover:rounded-sm">
                <a class="login" href="/login">Login</a>
                <a class="logout" href="/logout">Logout</a>
            </li>
        </ul>
        
    </nav>
</header>