@props(['product', 'isWishlisted' => false, 'class' => ''])

@auth
    @if (auth()->id() !== $product->user_id)
        @if ($isWishlisted)
            <form action="{{ route('wishlist.destroy', $product) }}" method="POST" {{ $attributes->merge(['class' => $class]) }}>
                @csrf
                @method('DELETE')
                <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/95 text-red-500 shadow-md ring-1 ring-stone-200/80 transition hover:scale-105 hover:bg-red-50" title="Remove from wishlist" aria-label="Remove from wishlist">
                    <span class="text-lg">♥</span>
                </button>
            </form>
        @else
            <form action="{{ route('wishlist.store', $product) }}" method="POST" {{ $attributes->merge(['class' => $class]) }}>
                @csrf
                <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/95 text-stone-500 shadow-md ring-1 ring-stone-200/80 transition hover:scale-105 hover:text-red-500" title="Save to wishlist" aria-label="Save to wishlist">
                    <span class="text-lg">♡</span>
                </button>
            </form>
        @endif
    @endif
@else
    <a href="{{ route('login') }}" {{ $attributes->merge(['class' => $class.' flex h-9 w-9 items-center justify-center rounded-full bg-white/95 text-stone-500 shadow-md ring-1 ring-stone-200/80 transition hover:text-red-500']) }} title="Login to save" aria-label="Login to save to wishlist">
        <span class="text-lg">♡</span>
    </a>
@endauth
