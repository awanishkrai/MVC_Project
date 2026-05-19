@extends('layouts.public')
@section('title', 'Wishlist — CraftNest')

@section('content')
<div class="cn-container py-10">
    <div class="mb-8">
        <p class="cn-eyebrow">Saved for later</p>
        <h1 class="font-display text-4xl font-bold text-stone-900">Your wishlist</h1>
        <p class="mt-2 text-stone-500">Handmade pieces you love — ready when you are.</p>
    </div>

    @if ($items->isEmpty())
        <x-empty-state title="Your wishlist is empty" description="Tap the heart on any product to save it here." icon="♡">
            <x-slot:action>
                <a href="{{ route('products.index') }}" class="cn-btn-primary">Browse marketplace</a>
            </x-slot:action>
        </x-empty-state>
    @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($items as $product)
                <article class="cn-card-hover group relative overflow-hidden">
                    <x-wishlist-button :product="$product" :is-wishlisted="true" class="absolute right-3 top-3 z-10" />
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="relative aspect-[4/5] overflow-hidden bg-craft-50">
                            <x-product-image :product="$product" img-class="h-full w-full object-cover transition group-hover:scale-105" fallback-class="flex h-full w-full items-center justify-center bg-craft-50" />
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-stone-500">{{ $product->shop->shop_name }}</p>
                            <h2 class="mt-1 font-display text-lg font-semibold text-stone-900 line-clamp-2">{{ $product->title }}</h2>
                            <p class="mt-2 text-xl font-bold text-craft-700">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </a>
                    <div class="flex gap-2 border-t border-stone-100 p-4">
                        @if ($product->isInStock())
                            <form action="{{ route('wishlist.move-to-cart', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="cn-btn-primary w-full !py-2 !text-xs">Move to cart</button>
                            </form>
                        @else
                            <span class="flex-1 rounded-2xl bg-stone-100 py-2 text-center text-xs text-stone-500">Out of stock</span>
                        @endif
                        <form action="{{ route('wishlist.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cn-btn-secondary !py-2 !text-xs">Remove</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
