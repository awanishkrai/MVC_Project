@extends('layouts.app')
@section('title', 'CraftNest — Handmade Marketplace')

@section('content')
<section class="overflow-hidden rounded-2xl bg-gradient-to-br from-amber-800 to-orange-900 px-8 py-16 text-white shadow-xl">
    <p class="text-sm font-medium uppercase tracking-wider text-amber-200">INT221 MVC Project</p>
    <h1 class="mt-2 text-4xl font-bold sm:text-5xl">Welcome to CraftNest</h1>
    <p class="mt-4 max-w-xl text-lg text-amber-100">
        Discover unique handmade goods from talented artists. Buy with heart, sell with passion.
    </p>

    <div class="mt-8 flex flex-wrap gap-3">
        @guest
            <a href="{{ route('register') }}" class="rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-amber-900 hover:bg-amber-50">
                Get started
            </a>
            <a href="{{ route('login') }}" class="rounded-lg border border-amber-200 px-5 py-2.5 text-sm font-semibold text-white hover:bg-amber-700">
                Log in
            </a>
        @else
            @if (auth()->user()->isBuyer())
                <a href="{{ route('buyer.home') }}" class="rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-amber-900">Go to home</a>
            @elseif (auth()->user()->isSeller())
                <a href="{{ route('seller.dashboard') }}" class="rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-amber-900">Seller dashboard</a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-amber-900">Admin panel</a>
            @endif
        @endguest
    </div>
</section>

<section class="mt-10 grid gap-6 sm:grid-cols-3">
    <article class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-amber-900">For Buyers</h2>
        <p class="mt-2 text-sm text-stone-600">Browse handmade products, add to cart, and place orders.</p>
    </article>
    <article class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-amber-900">For Sellers</h2>
        <p class="mt-2 text-sm text-stone-600">Open your shop and list unique crafts for the world to see.</p>
    </article>
    <article class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-amber-900">For Admins</h2>
        <p class="mt-2 text-sm text-stone-600">Manage the platform and keep CraftNest running smoothly.</p>
    </article>
</section>
@endsection
