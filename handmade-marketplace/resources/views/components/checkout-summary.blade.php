@props(['items', 'subtotal', 'shipping', 'total', 'itemCount' => null, 'showCheckout' => true])

@php
    $itemCount = $itemCount ?? $items->sum('quantity');
@endphp

<aside {{ $attributes->merge(['class' => 'cn-card sticky top-24 space-y-5 p-6']) }}>
    <div>
        <h2 class="font-display text-lg font-bold text-stone-900">Order summary</h2>
        <p class="mt-1 text-sm text-stone-500">{{ $itemCount }} {{ Str::plural('item', $itemCount) }}</p>
    </div>

    @if ($items->isNotEmpty())
        <ul class="max-h-48 space-y-3 overflow-y-auto border-b border-stone-100 pb-4 text-sm">
            @foreach ($items as $item)
                <li class="flex justify-between gap-3">
                    <span class="truncate text-stone-600">{{ $item['product']->title }} × {{ $item['quantity'] }}</span>
                    <span class="shrink-0 font-medium text-stone-800">${{ number_format($item['line_total'], 2) }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    <dl class="space-y-2 text-sm">
        <div class="flex justify-between">
            <dt class="text-stone-500">Subtotal</dt>
            <dd class="font-medium text-stone-800">${{ number_format($subtotal, 2) }}</dd>
        </div>
        <div class="flex justify-between">
            <dt class="text-stone-500">Shipping</dt>
            <dd class="font-medium text-stone-800">${{ number_format($shipping, 2) }}</dd>
        </div>
        <div class="flex justify-between border-t border-stone-100 pt-3 text-base">
            <dt class="font-semibold text-stone-900">Total</dt>
            <dd class="font-display font-bold text-craft-700">${{ number_format($total, 2) }}</dd>
        </div>
    </dl>

    @if ($showCheckout && $items->isNotEmpty())
        @auth
            <a href="{{ route('checkout.index') }}" class="cn-btn-primary block w-full text-center">Proceed to checkout</a>
        @else
            <a href="{{ route('login') }}" class="cn-btn-primary block w-full text-center">Login to checkout</a>
            <p class="text-center text-xs text-stone-400">Sign in to complete your purchase</p>
        @endauth
    @endif

    {{ $slot }}
</aside>
