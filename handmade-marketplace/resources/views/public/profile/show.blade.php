@extends('layouts.public')
@section('title', 'My Account — CraftNest')

@section('content')
<div class="cn-container max-w-4xl py-6">
    <article class="cn-card mb-6 overflow-hidden">
        <header class="cn-hero-gradient px-6 py-8 sm:px-8">
            <div class="flex flex-col items-center gap-4 sm:flex-row">
                <span class="flex h-20 w-20 items-center justify-center rounded-full bg-white/20 text-3xl font-bold text-white ring-4 ring-white/20">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                <div class="text-center sm:text-left">
                    <p class="text-xs font-semibold uppercase tracking-wider text-craft-200">Buyer account</p>
                    <h1 class="font-display text-2xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-craft-100">{{ $user->email }}</p>
                    <span class="mt-2 inline-block rounded-full bg-white/20 px-3 py-1 text-xs text-white">{{ ucfirst($user->role) }} · Joined {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        </header>
    </article>
    @include('partials.profile-forms', ['user' => $user])
</div>
@endsection
