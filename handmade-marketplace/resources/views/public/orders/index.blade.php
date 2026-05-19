@extends('layouts.public')
@section('title', 'My Orders — CraftNest')

@section('content')
<div class="cn-container py-10">
    <div class="mb-8">
        <p class="cn-eyebrow">Purchase history</p>
        <h1 class="font-display text-4xl font-bold text-stone-900">My orders</h1>
        <p class="mt-2 text-stone-500">Track status and view details for your CraftNest purchases.</p>
    </div>

    @if ($orders->isEmpty())
        <x-empty-state title="No orders yet" description="When you place an order, it will appear here with live status updates." icon="📦">
            <x-slot:action>
                <a href="{{ route('products.index') }}" class="cn-btn-primary">Start shopping</a>
            </x-slot:action>
        </x-empty-state>
    @else
        <div class="space-y-4">
            @foreach ($orders as $order)
                <article class="cn-card p-6 transition hover:shadow-md">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="font-display text-lg font-bold text-stone-900">{{ $order->formattedId() }}</p>
                            <p class="mt-1 text-sm text-stone-500">{{ $order->created_at->format('M j, Y · g:i A') }} · {{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <x-order-status-badge :status="$order->order_status" />
                            <x-payment-status-badge :status="$order->payment_status" />
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center justify-between gap-4 border-t border-stone-100 pt-4">
                        <p class="text-lg font-bold text-craft-700">${{ number_format($order->total_amount, 2) }}</p>
                        <a href="{{ route('orders.show', $order) }}" class="cn-btn-secondary !py-2 !text-sm">View details →</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
