@extends('layouts.app')
@section('title', 'Buyer Home — CraftNest')

@section('content')
<div class="rounded-2xl border border-stone-200 bg-white p-8 shadow-sm">
    <p class="text-sm font-medium text-amber-700">Buyer Dashboard</p>
    <h1 class="mt-1 text-3xl font-bold text-stone-900">Hello, {{ $user->name }}!</h1>
    <p class="mt-3 text-stone-600">
        Welcome to CraftNest. Browse handmade products from our talented sellers.
        Product listings and cart features will be added in the next modules.
    </p>

    <div class="mt-6 rounded-lg bg-amber-50 p-4 text-sm text-amber-900">
        <strong>Your role:</strong> Buyer &nbsp;|&nbsp; <strong>Email:</strong> {{ $user->email }}
    </div>
</div>
@endsection
