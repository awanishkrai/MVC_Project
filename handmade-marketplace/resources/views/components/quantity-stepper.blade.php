@props(['product', 'quantity', 'max' => 99])

<div {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full border border-stone-200 bg-white shadow-sm']) }}>
    <form action="{{ route('cart.update', $product) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <input type="hidden" name="quantity" value="{{ max(1, $quantity - 1) }}">
        <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-l-full text-stone-600 transition hover:bg-craft-50 hover:text-craft-800" aria-label="Decrease quantity">−</button>
    </form>
    <span class="min-w-[2rem] px-2 text-center text-sm font-semibold text-stone-800">{{ $quantity }}</span>
    <form action="{{ route('cart.update', $product) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <input type="hidden" name="quantity" value="{{ min($max, $quantity + 1) }}">
        <button type="submit" @disabled($quantity >= $max) class="flex h-9 w-9 items-center justify-center rounded-r-full text-stone-600 transition hover:bg-craft-50 hover:text-craft-800 disabled:cursor-not-allowed disabled:opacity-40" aria-label="Increase quantity">+</button>
    </form>
</div>
