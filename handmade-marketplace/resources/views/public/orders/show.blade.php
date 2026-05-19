@extends('layouts.public')
@section('title', $order->formattedId() . ' — CraftNest')

@section('content')
<div class="cn-container py-10">
    <nav class="mb-6 text-sm text-stone-500">
        <a href="{{ route('orders.index') }}" class="hover:text-craft-700">My orders</a>
        <span class="mx-2">/</span>
        <span class="text-stone-800">{{ $order->formattedId() }}</span>
    </nav>

    <div class="mb-8 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-bold text-stone-900">{{ $order->formattedId() }}</h1>
            <p class="mt-1 text-stone-500">Placed on {{ $order->created_at->format('F j, Y') }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-order-status-badge :status="$order->order_status" />
            <x-payment-status-badge :status="$order->payment_status" />
        </div>
    </div>

    {{-- Timeline --}}
    @php
        $steps = ['pending', 'processing', 'shipped', 'delivered'];
        $currentIndex = array_search($order->order_status, $steps, true) ?: 0;
    @endphp
    <div class="cn-card mb-8 p-6">
        <h2 class="font-display text-lg font-bold text-stone-900">Order progress</h2>
        <ol class="mt-6 flex flex-wrap justify-between gap-4">
            @foreach ($steps as $i => $step)
                <li class="flex flex-1 min-w-[4rem] flex-col items-center text-center">
                    <span @class([
                        'flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold',
                        'bg-craft-600 text-white' => $i <= $currentIndex,
                        'bg-stone-100 text-stone-400' => $i > $currentIndex,
                    ])>{{ $i + 1 }}</span>
                    <span @class(['mt-2 text-xs font-medium capitalize', 'text-craft-800' => $i <= $currentIndex, 'text-stone-400' => $i > $currentIndex])>{{ $step }}</span>
                </li>
            @endforeach
        </ol>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            <h2 class="font-display text-xl font-bold text-stone-900">Items</h2>
            @foreach ($order->items as $item)
                <article class="cn-card flex gap-4 p-4">
                    <div class="h-20 w-20 shrink-0 overflow-hidden rounded-xl">
                        <x-product-image :product="$item->product" img-class="h-20 w-20 rounded-xl object-cover" fallback-class="flex h-20 w-20 items-center justify-center rounded-xl bg-craft-50" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-stone-900">{{ $item->product->title }}</p>
                        <p class="text-sm text-stone-500">{{ $item->product->shop->shop_name }}</p>
                        <p class="mt-2 text-sm text-stone-600">Qty: {{ $item->quantity }} · ${{ number_format($item->price, 2) }} each</p>
                    </div>
                    <p class="font-bold text-craft-700">${{ number_format($item->lineTotal(), 2) }}</p>
                </article>
            @endforeach
        </div>

        <aside class="cn-card space-y-4 p-6">
            <h2 class="font-display text-lg font-bold text-stone-900">Summary</h2>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-stone-500">Subtotal</dt><dd>${{ number_format($order->subtotal(), 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Shipping</dt><dd>${{ number_format($order->shipping_amount, 2) }}</dd></div>
                <div class="flex justify-between border-t border-stone-100 pt-2 font-bold"><dt>Total</dt><dd class="text-craft-700">${{ number_format($order->total_amount, 2) }}</dd></div>
            </dl>
            <div class="border-t border-stone-100 pt-4 text-sm">
                <p class="font-semibold text-stone-700">Delivery address</p>
                <p class="mt-2 text-stone-600">
                    {{ $order->shipping_name }}<br>
                    {{ $order->shipping_phone }}<br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}
                </p>
            </div>
            <p class="text-sm capitalize text-stone-500">Payment: {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Card (Demo)' }}</p>
        </aside>
    </div>
</div>
@endsection
