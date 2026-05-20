@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'Order management')
@section('page-subtitle', 'Monitor all marketplace orders')

@section('content')
@if ($orders->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/50 px-8 py-16 text-center">
        <p class="text-4xl">🛒</p>
        <h3 class="mt-4 font-display text-xl font-semibold text-white">No orders yet</h3>
        <p class="mt-2 text-sm text-slate-400">Orders will appear here as buyers complete checkout.</p>
    </div>
@else
    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">
                <thead class="border-b border-slate-800 bg-slate-950/50 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-5 py-4">Order</th>
                        <th class="px-5 py-4">Buyer</th>
                        <th class="px-5 py-4">Items</th>
                        <th class="px-5 py-4">Total</th>
                        <th class="px-5 py-4">Payment</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-slate-800/30">
                            <td class="px-5 py-4">
                                <p class="font-semibold text-white">{{ $order->formattedId() }}</p>
                                <p class="text-xs text-slate-500">{{ $order->created_at->format('M j, Y') }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-slate-200">{{ $order->user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $order->user->email }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-300">
                                @foreach ($order->items->take(2) as $item)
                                    <p class="truncate max-w-[180px]">{{ $item->product->title }} ×{{ $item->quantity }}</p>
                                @endforeach
                                @if ($order->items->count() > 2)
                                    <p class="text-xs text-slate-500">+{{ $order->items->count() - 2 }} more</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-semibold text-emerald-400">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-5 py-4">
                                <p class="capitalize text-slate-300">{{ $order->payment_method === 'cod' ? 'COD' : 'Card' }}</p>
                                <x-payment-status-badge :status="$order->payment_status" />
                            </td>
                            <td class="px-5 py-4"><x-order-status-badge :status="$order->order_status" /></td>
                            <td class="px-5 py-4">
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="order_status" class="rounded-lg border border-slate-700 bg-slate-800 px-2 py-1.5 text-xs text-white">
                                        @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                            <option value="{{ $status }}" @selected($order->order_status === $status)>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="rounded-lg bg-craft-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-craft-500">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
@endif
@endsection
