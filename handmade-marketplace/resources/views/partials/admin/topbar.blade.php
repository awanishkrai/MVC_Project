<header class="sticky top-0 z-30 flex h-14 items-center justify-between border-b border-slate-800 bg-slate-900/95 px-4 backdrop-blur sm:px-6">
    <div>
        <h1 class="font-display text-lg font-semibold text-white">@yield('page-title', 'Admin')</h1>
        @hasSection('page-subtitle')
            <p class="text-xs text-slate-400">@yield('page-subtitle')</p>
        @endif
    </div>
    <div class="flex items-center gap-3 text-sm text-slate-400">
        <span>{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="rounded-lg px-2 py-1 text-xs hover:bg-slate-800 hover:text-white">Logout</button>
        </form>
    </div>
</header>
