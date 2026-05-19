<aside class="fixed inset-y-0 left-0 z-40 hidden w-64 flex-col border-r border-slate-800 bg-slate-900 lg:flex">
    <div class="flex h-16 items-center gap-2 border-b border-slate-800 px-5">
        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-700 text-xs font-bold text-white">CN</span>
        <div>
            <p class="font-display text-sm font-bold text-white">CraftNest</p>
            <p class="text-[10px] uppercase tracking-wider text-slate-400">Admin control</p>
        </div>
    </div>

    <nav class="flex-1 space-y-1 p-3">
        <x-panel-nav-item href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" icon="📊" theme="dark">Dashboard</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('admin.categories.index') }}" :active="request()->routeIs('admin.categories.*')" icon="🏷️" theme="dark">Categories</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('admin.products.index') }}" :active="request()->routeIs('admin.products.*')" icon="📦" theme="dark" badge="Soon">Products</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')" icon="👥" theme="dark" badge="Soon">Users</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('admin.orders.index') }}" :active="request()->routeIs('admin.orders.*')" icon="🛒" theme="dark" badge="Soon">Orders</x-panel-nav-item>
        <x-panel-nav-item href="{{ route('admin.reports.index') }}" :active="request()->routeIs('admin.reports.*')" icon="📈" theme="dark" badge="Soon">Reports</x-panel-nav-item>
    </nav>

    <div class="border-t border-slate-800 p-4">
        <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-white">← Back to marketplace</a>
    </div>
</aside>
