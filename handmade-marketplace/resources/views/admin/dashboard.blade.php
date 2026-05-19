@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Platform overview')
@section('page-subtitle', 'CraftNest administration')

@section('content')
<div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ([
        ['Users', $stats['users'], '👥'],
        ['Buyers', $stats['buyers'], '🛒'],
        ['Sellers', $stats['sellers'], '🎨'],
        ['Shops', $stats['shops'], '🏪'],
        ['Products', $stats['products'], '📦'],
        ['Categories', $stats['categories'], '🏷️'],
    ] as [$label, $value, $icon])
        <article class="rounded-2xl border border-slate-800 bg-slate-900 p-5">
            <div class="flex items-center gap-3">
                <span class="text-2xl">{{ $icon }}</span>
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-500">{{ $label }}</p>
                    <p class="font-display text-2xl font-bold text-white">{{ $value }}</p>
                </div>
            </div>
        </article>
    @endforeach
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <section class="rounded-2xl border border-slate-800 bg-slate-900">
        <div class="border-b border-slate-800 px-5 py-4">
            <h2 class="font-semibold text-white">Recent users</h2>
        </div>
        <ul class="divide-y divide-slate-800">
            @foreach ($recentUsers as $u)
                <li class="flex items-center justify-between px-5 py-3 text-sm">
                    <span class="text-slate-200">{{ $u->name }}</span>
                    <span class="rounded-full bg-slate-800 px-2 py-0.5 text-xs text-slate-400">{{ $u->role }}</span>
                </li>
            @endforeach
        </ul>
    </section>
    <section class="rounded-2xl border border-slate-800 bg-slate-900">
        <div class="border-b border-slate-800 px-5 py-4">
            <h2 class="font-semibold text-white">Recent products</h2>
        </div>
        <ul class="divide-y divide-slate-800">
            @foreach ($recentProducts as $p)
                <li class="px-5 py-3 text-sm">
                    <p class="text-slate-200">{{ $p->title }}</p>
                    <p class="text-xs text-slate-500">{{ $p->shop?->shop_name }} · ${{ number_format($p->price, 2) }}</p>
                </li>
            @endforeach
        </ul>
    </section>
</div>

<div class="mt-6">
    <a href="{{ route('admin.categories.index') }}" class="inline-flex rounded-xl bg-craft-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-craft-700">Manage categories →</a>
</div>
@endsection
