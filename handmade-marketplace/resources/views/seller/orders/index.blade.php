@extends('layouts.seller')
@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'Manage orders for your handmade products')

@section('content')
@if ($orders->isEmpty())
    <x-empty-state title="No orders yet" description="When buyers purchase your products, orders will appear here for fulfillment." icon="🛒" />
@else
    <div class="space-y-6">
        @foreach ($orders as $order)
            @php
                $sellerItems = $order->items->filter(fn ($item) => $item->product->user_id === $sellerId);
                $sellerTotal = $sellerItems->sum(fn ($item) => $item->lineTotal());
            @endphp
            <article class="cn-card overflow-hidden">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-stone-100 bg-stone-50/50 px-5 py-4">
                    <div>
                        <p class="font-display font-bold text-stone-900">{{ $order->formattedId() }}</p>
                        <p class="mt-1 text-sm text-stone-500">{{ $order->created_at->format('M j, Y · g:i A') }}</p>
                        <p class="mt-1 text-sm text-stone-600">Buyer: <span class="font-medium">{{ $order->user->name }}</span></p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <x-order-status-badge :status="$order->order_status" />
                        <x-payment-status-badge :status="$order->payment_status" />
                    </div>
                </div>

                <div class="p-5">
                    <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-stone-500">Your items in this order</p>
                    <ul class="space-y-3">
                        @foreach ($sellerItems as $item)
                            <li class="flex flex-wrap items-center justify-between gap-3 rounded-xl bg-craft-50/50 px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 shrink-0 overflow-hidden rounded-lg">
                                        <x-product-image :product="$item->product" img-class="h-12 w-12 rounded-lg object-cover" fallback-class="flex h-12 w-12 items-center justify-center rounded-lg bg-craft-100" placeholder="🧵" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-stone-900">{{ $item->product->title }}</p>
                                        <p class="text-sm text-stone-500">Qty {{ $item->quantity }} · ${{ number_format($item->price, 2) }} each</p>
                                    </div>
                                </div>
                                <p class="font-bold text-craft-700">${{ number_format($item->lineTotal(), 2) }}</p>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-5 flex flex-wrap items-center justify-between gap-4 border-t border-stone-100 pt-4">
                        <p class="text-sm text-stone-600">Your portion: <span class="font-bold text-stone-900">${{ number_format($sellerTotal, 2) }}</span></p>

                        <form action="{{ route('seller.orders.update-status', $order) }}" method="POST" class="flex flex-wrap items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="order_status" class="cn-input !w-auto !py-2 !text-sm">
                                @foreach (['pending', 'processing', 'shipped', 'delivered'] as $status)
                                    <option value="{{ $status }}" @selected($order->order_status === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="cn-btn-primary !py-2 !text-sm">Update status</button>
                        </form>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
@endif
@endsection
