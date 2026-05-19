<footer class="mt-auto border-t border-stone-200 bg-white">
    <div class="cn-container grid gap-8 py-12 sm:grid-cols-3">
        <div>
            <p class="font-display text-lg font-bold text-stone-900">CraftNest</p>
            <p class="mt-2 text-sm text-stone-500">A handmade marketplace built for INT221 MVC Programming.</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-stone-400">Explore</p>
            <ul class="mt-3 space-y-2 text-sm text-stone-600">
                <li><a href="{{ route('products.index') }}" class="hover:text-craft-700">Marketplace</a></li>
                <li><a href="{{ route('home') }}" class="hover:text-craft-700">Home</a></li>
            </ul>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-stone-400">Sell</p>
            <ul class="mt-3 space-y-2 text-sm text-stone-600">
                <li><a href="{{ route('register') }}" class="hover:text-craft-700">Open a shop</a></li>
                @auth
                    @if (auth()->user()->isSeller())
                        <li><a href="{{ route('seller.dashboard') }}" class="hover:text-craft-700">Seller panel</a></li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
    <div class="border-t border-stone-100 py-4 text-center text-xs text-stone-400">
        &copy; {{ date('Y') }} CraftNest · Laravel MVC University Project
    </div>
</footer>
