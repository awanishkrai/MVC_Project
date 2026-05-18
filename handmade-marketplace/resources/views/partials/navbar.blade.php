<nav class="sticky top-0 z-50 border-b border-stone-200/60 bg-white/85 shadow-sm backdrop-blur-xl">
    <div class="cn-container flex h-16 items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="group flex items-center gap-2.5">
            <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-craft-500 to-craft-800 text-sm font-bold text-white shadow-md transition group-hover:scale-105">CN</span>
            <span class="font-display text-xl font-bold text-stone-900">Craft<span class="text-craft-600">Nest</span></span>
        </a>

        <div class="hidden items-center gap-1 md:flex">
            <a href="{{ route('products.index') }}" @class(['rounded-xl px-3 py-2 text-sm font-medium transition', 'bg-craft-100 text-craft-800' => request()->routeIs('products.*'), 'text-stone-600 hover:bg-stone-100' => !request()->routeIs('products.*')])>Marketplace</a>
            @auth
                @if (auth()->user()->isBuyer())
                    <a href="{{ route('buyer.home') }}" @class(['rounded-xl px-3 py-2 text-sm font-medium transition', 'bg-craft-100 text-craft-800' => request()->routeIs('buyer.home')])>Home</a>
                @endif
                @if (auth()->user()->isSeller())
                    <a href="{{ route('seller.dashboard') }}" @class(['rounded-xl px-3 py-2 text-sm font-medium transition', 'bg-craft-100 text-craft-800' => request()->routeIs('seller.dashboard')])>Dashboard</a>
                    <a href="{{ route('shop.dashboard') }}" @class(['rounded-xl px-3 py-2 text-sm font-medium transition', 'bg-craft-100 text-craft-800' => request()->routeIs('shop.*')])>My Shop</a>
                    <a href="{{ route('products.manage') }}" @class(['rounded-xl px-3 py-2 text-sm font-medium transition', 'bg-craft-100 text-craft-800' => request()->routeIs('products.manage', 'products.create', 'products.edit')])>Products</a>
                @endif
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" @class(['rounded-xl px-3 py-2 text-sm font-medium transition', 'bg-craft-100 text-craft-800' => request()->routeIs('admin.*')])>Admin</a>
                @endif
            @endauth
        </div>

        <div class="flex items-center gap-2">
            @auth
                <a href="{{ route('profile.show') }}" @class(['hidden rounded-xl px-3 py-2 text-sm font-medium sm:inline-flex', 'bg-craft-100 text-craft-800' => request()->routeIs('profile.*'), 'text-stone-600 hover:bg-stone-100' => !request()->routeIs('profile.*')])>Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="cn-btn-secondary !rounded-xl !py-2 !px-3 text-xs">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="cn-btn-ghost !rounded-xl !py-2 text-sm">Login</a>
                <a href="{{ route('register') }}" class="cn-btn-primary !rounded-xl !py-2 text-sm shadow-craft">Join</a>
            @endauth
        </div>
    </div>
</nav>
