<header class="sticky top-0 z-30 flex h-14 items-center justify-between border-b border-stone-200 bg-white/95 px-4 backdrop-blur sm:px-6">
    <div>
        <h1 class="font-display text-lg font-semibold text-stone-900">@yield('page-title', 'Dashboard')</h1>
        @hasSection('page-subtitle')
            <p class="text-xs text-stone-500">@yield('page-subtitle')</p>
        @endif
    </div>
    <div class="flex items-center gap-2">
        @if (auth()->user()->shop)
            <a href="{{ route('shops.show', auth()->user()->shop) }}" target="_blank" class="cn-btn-secondary hidden !py-2 !text-xs sm:inline-flex">Preview shop</a>
        @endif
        <a href="{{ route('seller.products.create') }}" class="cn-btn-primary !py-2 !text-xs">+ Add product</a>
    </div>
</header>
