@props(['item'])

@php
    $product = $item['product'];
    $quantity = $item['quantity'];
    $lineTotal = $item['line_total'];
@endphp

<article {{ $attributes->merge(['class' => 'cn-card flex flex-col gap-4 p-4 sm:flex-row sm:items-center sm:gap-6']) }}>
    <a href="{{ route('products.show', $product) }}" class="block h-24 w-24 shrink-0 overflow-hidden rounded-xl bg-craft-50 sm:h-28 sm:w-28">
        <x-product-image :product="$product" img-class="h-24 w-24 object-cover transition hover:scale-105 sm:h-28 sm:w-28" fallback-class="flex h-24 w-24 items-center justify-center bg-craft-50 sm:h-28 sm:w-28" placeholder="🧵" />
    </a>

    <div class="min-w-0 flex-1">
        <div class="flex flex-wrap items-start justify-between gap-2">
            <div>
                <a href="{{ route('products.show', $product) }}" class="font-display text-lg font-semibold text-stone-900 hover:text-craft-700">{{ $product->title }}</a>
                <p class="mt-0.5 text-sm text-stone-500">by {{ $product->shop->shop_name }}</p>
            </div>
            <x-stock-badge :status="$product->stock_status" />
        </div>
        <p class="mt-2 text-sm text-stone-600">${{ number_format($product->price, 2) }} each</p>
        @if ($product->delivery_time)
            <p class="mt-1 text-xs text-stone-400">Est. delivery: {{ $product->delivery_time }}</p>
        @endif
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4 sm:flex-col sm:items-end">
        <x-quantity-stepper :product="$product" :quantity="$quantity" :max="$product->quantity" />
        <p class="font-display text-lg font-bold text-craft-700">${{ number_format($lineTotal, 2) }}</p>
        <form action="{{ route('cart.remove', $product) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm font-medium text-red-600 transition hover:text-red-800">Remove</button>
        </form>
    </div>
</article>
