<aside class="fixed inset-y-0 left-0 z-40 hidden w-64 flex-col border-r border-stone-200 bg-white lg:flex">
    <div class="flex h-16 items-center gap-2 border-b border-stone-100 px-5">
        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-craft-600 to-craft-800 text-xs font-bold text-white">CN</span>
        <div>
            <p class="font-display text-sm font-bold text-stone-900">Seller Studio</p>
            <p class="text-[10px] uppercase tracking-wider text-craft-600">Business panel</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto p-3">
        <x-panel-nav-item href="{{ route('seller.dashboard') }}" :active="request()->routeIs('seller.dashboard')" icon="📊">Dashboard</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('seller.shop.index') }}" :active="request()->routeIs('seller.shop.*')" icon="🏪">My Shop</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('seller.products.index') }}" :active="request()->routeIs('seller.products.*')" icon="📦">Products</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('seller.orders.index') }}" :active="request()->routeIs('seller.orders.*')" icon="🛒">Orders</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('seller.messages.index') }}" :active="request()->routeIs('seller.messages.*')" icon="💬" badge="Soon">Messages</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('seller.analytics.index') }}" :active="request()->routeIs('seller.analytics.*')" icon="📈" badge="Soon">Analytics</x-panel-nav-item>

        <div class="my-4 border-t border-stone-100 pt-4">
            <x-panel-nav-item href="{{ route('seller.settings') }}" :active="request()->routeIs('seller.settings')" icon="⚙️">Settings</x-panel-nav-item>
            <a href="{{ route('home') }}" class="mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-stone-500 transition hover:bg-stone-50">
                <span aria-hidden="true">🌐</span> View marketplace
            </a>
        </div>
    </nav>

    <div class="border-t border-stone-100 p-4">
        @if (auth()->user()->shop)
            <p class="truncate text-xs font-medium text-stone-800">{{ auth()->user()->shop->shop_name }}</p>
            <p class="text-[10px] text-stone-400">Active shop</p>
        @endif

        <div class="mt-4 space-y-1">
            <a href="{{ route('seller.settings') }}" class="flex items-center gap-2 rounded-lg px-2 py-2 text-sm text-stone-600 transition hover:bg-stone-50">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-craft-100 text-xs font-bold text-craft-800">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="truncate">{{ auth()->user()->name }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-2 py-2 text-sm font-medium text-stone-500 transition hover:bg-red-50 hover:text-red-700">
                    <span aria-hidden="true">↩</span> Log out
                </button>
            </form>
        </div>
    </div>
</aside>
