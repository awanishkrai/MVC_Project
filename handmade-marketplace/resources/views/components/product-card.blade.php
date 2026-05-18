@props(['product'])

<a href="{{ route('products.show', $product) }}" class="cn-card-hover group block overflow-hidden">
    <div class="relative aspect-[4/5] overflow-hidden bg-gradient-to-br from-craft-100 to-stone-100">
        @if ($product->imageUrl())
            <img src="{{ $product->imageUrl() }}" alt="{{ $product->title }}"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
        @else
            <div class="flex h-full items-center justify-center text-5xl opacity-40">🧵</div>
        @endif
        @if ($product->category)
            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-craft-800 shadow-sm backdrop-blur">
                {{ $product->category->icon }} {{ $product->category->name }}
            </span>
        @endif
        @unless ($product->isInStock())
            <span class="absolute right-3 top-3 rounded-full bg-stone-900/80 px-2.5 py-1 text-xs font-medium text-white">Sold out</span>
        @endunless
    </div>
    <div class="p-4">
        <p class="text-xs font-medium text-stone-500">{{ $product->shop?->shop_name ?? 'CraftNest' }}</p>
        <h3 class="mt-1 font-display text-lg font-semibold text-stone-900 group-hover:text-craft-700 line-clamp-2">{{ $product->title }}</h3>
        <div class="mt-3 flex items-center justify-between">
            <p class="text-xl font-bold text-craft-700">${{ number_format($product->price, 2) }}</p>
            <span class="text-xs text-stone-400">{{ $product->delivery_time ?? 'Ships in 3–5 days' }}</span>
        </div>
    </div>
</a>
