<header class="sticky top-0 z-50 border-b border-stone-200/80 bg-white/95 shadow-sm backdrop-blur-md">
    <div class="cn-container">
        <div class="flex h-16 items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-craft-500 to-craft-800 text-sm font-bold text-white shadow-md">CN</span>
                <span class="hidden font-display text-xl font-bold text-stone-900 sm:inline">Craft<span class="text-craft-600">Nest</span></span>
            </a>

            <form action="{{ route('products.index') }}" method="GET" class="hidden max-w-md flex-1 md:block">
                <div class="relative">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search handmade goods..."
                        class="cn-input !rounded-full !py-2.5 !pl-10 !pr-4">
                    <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </form>

            <nav class="flex items-center gap-1 sm:gap-2">
                @auth
                    <x-notification-bell class="hidden sm:block" />
                @endauth
                <a href="{{ route('products.index') }}" @class(['hidden rounded-full px-3 py-2 text-sm font-medium sm:inline-flex', 'bg-craft-100 text-craft-800' => request()->routeIs('products.*'), 'text-stone-600 hover:bg-stone-100' => !request()->routeIs('products.*')])>Shop</a>

                <a href="{{ route('cart.index') }}" @class(['relative rounded-full px-3 py-2 text-sm font-medium', 'bg-craft-100 text-craft-800' => request()->routeIs('cart.*'), 'text-stone-600 hover:bg-stone-100' => !request()->routeIs('cart.*')])>
                    Cart
                    @if (($cartCount ?? 0) > 0)
                        <span class="absolute -right-0.5 -top-0.5 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-craft-600 px-1 text-[10px] font-bold text-white">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <a href="{{ route('wishlist.index') }}" @class(['relative hidden rounded-full px-3 py-2 text-sm font-medium sm:inline-flex', 'bg-craft-100 text-craft-800' => request()->routeIs('wishlist.*'), 'text-stone-600 hover:bg-stone-100' => !request()->routeIs('wishlist.*')])>
                        Wishlist
                        @if (($wishlistCount ?? 0) > 0)
                            <span class="absolute -right-0.5 -top-0.5 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white">{{ $wishlistCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('orders.index') }}" @class(['hidden rounded-full px-3 py-2 text-sm font-medium sm:inline-flex', 'bg-craft-100 text-craft-800' => request()->routeIs('orders.*'), 'text-stone-600 hover:bg-stone-100' => !request()->routeIs('orders.*')])>Orders</a>
                    @if (auth()->user()->isSeller())
                        <a href="{{ route('seller.dashboard') }}" class="hidden rounded-full bg-stone-900 px-3 py-2 text-xs font-semibold text-white hover:bg-stone-800 sm:inline-flex">Seller panel</a>
                    @endif
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hidden rounded-full bg-slate-800 px-3 py-2 text-xs font-semibold text-white sm:inline-flex">Admin</a>
                    @endif
                    <a href="{{ route('profile.show') }}" @class(['rounded-full px-3 py-2 text-sm font-medium', 'bg-craft-100 text-craft-800' => request()->routeIs('profile.*'), 'text-stone-600 hover:bg-stone-100' => !request()->routeIs('profile.*')])>Account</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="rounded-full px-3 py-2 text-sm text-stone-500 hover:bg-stone-100">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-full px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-100">Login</a>
                    <a href="{{ route('register') }}" class="cn-btn-primary !rounded-full !py-2 !text-sm">Join</a>
                @endauth
            </nav>
        </div>
    </div>
</header>
