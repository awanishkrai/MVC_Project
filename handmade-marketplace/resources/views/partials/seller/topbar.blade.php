<header class="sticky top-0 z-30 flex h-14 items-center justify-between border-b border-stone-200 bg-white/95 px-4 backdrop-blur sm:px-6">
    <div class="min-w-0 flex-1">
        <h1 class="truncate font-display text-lg font-semibold text-stone-900">@yield('page-title', 'Dashboard')</h1>
        @hasSection('page-subtitle')
            <p class="truncate text-xs text-stone-500">@yield('page-subtitle')</p>
        @endif
    </div>
    <div class="flex shrink-0 items-center gap-2">
        @if (auth()->user()->shop)
            <a href="{{ route('shops.show', auth()->user()->shop) }}" target="_blank" rel="noopener" class="cn-btn-secondary hidden !py-2 !text-xs sm:inline-flex">Preview shop</a>
        @endif
        <a href="{{ route('seller.products.create') }}" class="cn-btn-primary hidden !py-2 !text-xs sm:inline-flex">+ Add product</a>
        <a href="{{ route('home') }}" class="cn-btn-ghost !py-2 !text-xs lg:hidden" title="Marketplace">🌐</a>
        <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
            @csrf
            <button type="submit" class="cn-btn-ghost !py-2 !text-xs text-stone-500" title="Log out">Log out</button>
        </form>
    </div>
</header>
