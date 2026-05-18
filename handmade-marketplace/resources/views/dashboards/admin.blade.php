@extends('layouts.app')
@section('title', 'Admin — CraftNest')

@section('content')
<div class="mb-8">
    <p class="cn-eyebrow">Administration</p>
    <h1 class="cn-page-header">Platform overview</h1>
</div>

<div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ([
        ['Users', $stats['users'], '👥'],
        ['Buyers', $stats['buyers'], '🛒'],
        ['Sellers', $stats['sellers'], '🎨'],
        ['Shops', $stats['shops'], '🏪'],
        ['Products', $stats['products'], '📦'],
        ['Categories', $stats['categories'], '🏷️'],
    ] as [$label, $value, $icon])
        <article class="cn-card flex items-center gap-4 p-5">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-craft-100 text-2xl">{{ $icon }}</span>
            <div>
                <p class="text-sm text-stone-500">{{ $label }}</p>
                <p class="font-display text-2xl font-bold text-stone-900">{{ $value }}</p>
            </div>
        </article>
    @endforeach
</div>

<div class="cn-card p-6">
    <h2 class="font-display text-lg font-semibold">Quick links</h2>
    <div class="mt-4 flex flex-wrap gap-3">
        <a href="{{ route('admin.categories.index') }}" class="cn-btn-primary">Manage categories</a>
        <a href="{{ route('products.index') }}" class="cn-btn-secondary">View marketplace</a>
    </div>
</div>
@endsection
