<nav class="border-b border-stone-200 bg-white shadow-sm">
    <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4 sm:px-6">
        <a href="{{ route('home') }}" class="text-xl font-bold text-amber-800">CraftNest</a>

        <div class="flex items-center gap-4 text-sm font-medium">
            @auth
                <span class="hidden text-stone-500 sm:inline">
                    {{ auth()->user()->name }}
                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs text-amber-900">{{ ucfirst(auth()->user()->role) }}</span>
                </span>

                @if (auth()->user()->isBuyer())
                    <a href="{{ route('buyer.home') }}" class="text-stone-600 hover:text-amber-800">Home</a>
                @endif

                @if (auth()->user()->isSeller())
                    <a href="{{ route('seller.dashboard') }}" class="text-stone-600 hover:text-amber-800">Dashboard</a>
                    <a href="{{ route('shop.dashboard') }}" class="text-stone-600 hover:text-amber-800">My Shop</a>
                @endif

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-stone-600 hover:text-amber-800">Admin</a>
                @endif

                <a href="{{ route('profile.edit') }}" class="text-stone-600 hover:text-amber-800">Profile</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="rounded-lg bg-stone-800 px-3 py-1.5 text-white hover:bg-stone-700">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-stone-600 hover:text-amber-800">Login</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-amber-700 px-3 py-1.5 text-white hover:bg-amber-800">Register</a>
            @endauth
        </div>
    </div>
</nav>
