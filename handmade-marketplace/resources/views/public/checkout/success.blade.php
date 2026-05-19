@extends('layouts.public')
@section('title', 'Order Confirmed — CraftNest')

@section('content')
<div class="cn-container py-16">
    <div class="mx-auto max-w-2xl text-center">
        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-4xl">✓</div>
        <p class="cn-eyebrow">Order confirmed</p>
        <h1 class="font-display text-4xl font-bold text-stone-900">Thank you for your order!</h1>
        <p class="mt-4 text-stone-600">Your handmade treasures are on their way. We've sent the details to your account.</p>

        <div class="cn-card mt-10 p-8 text-left">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-stone-100 pb-4">
                <div>
                    <p class="text-sm text-stone-500">Order number</p>
                    <p class="font-display text-2xl font-bold text-craft-700">{{ $order->formattedId() }}</p>
                </div>
                <x-order-status-badge :status="$order->order_status" />
            </div>

            <dl class="mt-6 grid gap-4 text-sm sm:grid-cols-2">
                <div>
                    <dt class="font-semibold text-stone-700">Total paid</dt>
                    <dd class="text-stone-600">${{ number_format($order->total_amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-stone-700">Payment</dt>
                    <dd class="capitalize text-stone-600">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Card (Demo)' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="font-semibold text-stone-700">Deliver to</dt>
                    <dd class="text-stone-600">
                        {{ $order->shipping_name }}<br>
                        {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}
                    </dd>
                </div>
            </dl>

            <ul class="mt-6 space-y-3 border-t border-stone-100 pt-6">
                @foreach ($order->items as $item)
                    <li class="flex justify-between gap-4 text-sm">
                        <span class="text-stone-600">{{ $item->product->title }} × {{ $item->quantity }}</span>
                        <span class="font-medium text-stone-800">${{ number_format($item->lineTotal(), 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('orders.show', $order) }}" class="cn-btn-secondary">View order details</a>
            <a href="{{ route('products.index') }}" class="cn-btn-primary">Continue shopping</a>
        </div>
    </div>
</div>
@endsection
