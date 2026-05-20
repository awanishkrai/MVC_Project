<footer class="mt-auto border-t border-stone-200 bg-white dark:border-stone-800 dark:bg-stone-900">
    <div class="cn-container grid gap-8 py-12 sm:grid-cols-3">
        <div>
            <p class="font-display text-lg font-bold text-stone-900 dark:text-white">CraftNest</p>
            <p class="mt-2 text-sm text-stone-500 dark:text-stone-400">A multi-vendor handmade marketplace connecting artisans with buyers who value craft.</p>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-stone-400">Explore</p>
            <ul class="mt-3 space-y-2 text-sm text-stone-600 dark:text-stone-400">
                <li><a href="{{ route('products.index') }}" class="hover:text-craft-700 dark:hover:text-craft-400">Marketplace</a></li>
                <li><a href="{{ route('home') }}" class="hover:text-craft-700 dark:hover:text-craft-400">Home</a></li>
            </ul>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-stone-400">Sell</p>
            <ul class="mt-3 space-y-2 text-sm text-stone-600 dark:text-stone-400">
                <li><a href="{{ route('register') }}" class="hover:text-craft-700 dark:hover:text-craft-400">Open a shop</a></li>
                @auth
                    @if (auth()->user()->isSeller())
                        <li><a href="{{ route('seller.dashboard') }}" class="hover:text-craft-700 dark:hover:text-craft-400">Seller panel</a></li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
    <div class="border-t border-stone-100 py-4 text-center text-xs text-stone-400 dark:border-stone-800 dark:text-stone-500">
        &copy; {{ date('Y') }} CraftNest · Handmade Marketplace
    </div>
</footer>
