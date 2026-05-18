@extends('layouts.app')
@section('title', 'Admin Dashboard — CraftNest')

@section('content')
<div class="rounded-2xl border border-stone-200 bg-white p-8 shadow-sm">
    <p class="text-sm font-medium text-red-700">Admin Dashboard</p>
    <h1 class="mt-1 text-3xl font-bold text-stone-900">Admin Panel</h1>
    <p class="mt-3 text-stone-600">
        Welcome, {{ $user->name }}. Use this area to manage users, shops, and platform settings
        (features coming in later modules).
    </p>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-lg border border-stone-200 p-4 text-center">
            <p class="text-2xl font-bold text-amber-800">{{ \App\Models\User::where('role', 'buyer')->count() }}</p>
            <p class="text-sm text-stone-500">Buyers</p>
        </div>
        <div class="rounded-lg border border-stone-200 p-4 text-center">
            <p class="text-2xl font-bold text-amber-800">{{ \App\Models\User::where('role', 'seller')->count() }}</p>
            <p class="text-sm text-stone-500">Sellers</p>
        </div>
        <div class="rounded-lg border border-stone-200 p-4 text-center">
            <p class="text-2xl font-bold text-amber-800">{{ \App\Models\User::count() }}</p>
            <p class="text-sm text-stone-500">Total users</p>
        </div>
    </div>
</div>
@endsection
