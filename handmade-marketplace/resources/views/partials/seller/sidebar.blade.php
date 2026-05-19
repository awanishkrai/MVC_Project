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
        <x-panel-nav-item href="{{ route('seller.orders.index') }}" :active="request()->routeIs('seller.orders.*')" icon="🛒" badge="Soon">Orders</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('seller.messages.index') }}" :active="request()->routeIs('seller.messages.*')" icon="💬" badge="Soon">Messages</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('seller.analytics.index') }}" :active="request()->routeIs('seller.analytics.*')" icon="📈" badge="Soon">Analytics</x-panel-nav-item>

        <div class="my-4 border-t border-stone-100 pt-4">
            <x-panel-nav-item href="{{ route('seller.settings') }}" :active="request()->routeIs('seller.settings')" icon="⚙️">Settings</x-panel-nav-item>
            <a href="{{ route('home') }}" class="mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-stone-500 hover:bg-stone-50">
                <span>🌐</span> View marketplace
            </a>
        </div>
    </nav>

    @if (auth()->user()->shop)
        <div class="border-t border-stone-100 p-4">
            <p class="truncate text-xs font-medium text-stone-800">{{ auth()->user()->shop->shop_name }}</p>
            <p class="text-[10px] text-stone-400">Active shop</p>
        </div>
    @endif
</aside>
