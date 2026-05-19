@props(['product'])

@php
    $wishlisted = in_array($product->id, $wishlistedProductIds ?? [], true);
@endphp

<div class="cn-card-hover group relative overflow-hidden">
    <div class="absolute right-3 top-3 z-10" onclick="event.preventDefault(); event.stopPropagation();">
        <x-wishlist-button :product="$product" :is-wishlisted="$wishlisted" />
    </div>
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="relative aspect-[4/5] overflow-hidden bg-gradient-to-br from-craft-100 to-stone-100">
            <x-product-image :product="$product" img-class="h-full w-full object-cover transition duration-500 group-hover:scale-110" fallback-class="flex h-full w-full items-center justify-center bg-gradient-to-br from-craft-100 to-stone-100" />
            @if ($product->category)
                <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-craft-800 shadow-sm backdrop-blur">
                    {{ $product->category->icon }} {{ $product->category->name }}
                </span>
            @endif
            @unless ($product->isInStock())
                <span class="absolute right-3 bottom-3 rounded-full bg-stone-900/80 px-2.5 py-1 text-xs font-medium text-white">Sold out</span>
            @endunless
        </div>
        <div class="p-4">
            <p class="text-xs font-medium text-stone-500">{{ $product->shop?->shop_name ?? 'CraftNest' }}</p>
            <h3 class="mt-1 font-display text-lg font-semibold text-stone-900 group-hover:text-craft-700 line-clamp-2">{{ $product->title }}</h3>
            @if ($product->hasReviews())
                <div class="mt-1 flex items-center gap-1 text-xs text-stone-500">
                    <x-rating-stars :rating="$product->average_rating" size="sm" />
                    <span>({{ $product->reviews_count }})</span>
                </div>
            @endif
            <div class="mt-3 flex items-center justify-between">
                <p class="text-xl font-bold text-craft-700">${{ number_format($product->price, 2) }}</p>
                <span class="text-xs text-stone-400">{{ $product->delivery_time ?? 'Ships in 3–5 days' }}</span>
            </div>
        </div>
    </a>
</div>
