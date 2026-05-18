@extends('layouts.app')
@section('title', 'My Profile — CraftNest')

@section('content')
{{-- Hero strip --}}
<div class="cn-card mb-8 overflow-hidden">
    <div class="cn-hero-gradient relative px-8 py-10 sm:px-10">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
        <div class="relative flex flex-col items-center gap-6 sm:flex-row sm:items-end">
            <div class="flex h-28 w-28 items-center justify-center rounded-full bg-white/20 text-4xl font-bold text-white ring-4 ring-white/30 backdrop-blur">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="text-center sm:text-left">
                <p class="cn-eyebrow !text-craft-200">Account settings</p>
                <h1 class="font-display text-3xl font-bold text-white sm:text-4xl">{{ $user->name }}</h1>
                <p class="mt-1 text-craft-100">{{ $user->email }}</p>
                <div class="mt-3 inline-flex items-center gap-2">
                    <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-white backdrop-blur">{{ ucfirst($user->role) }}</span>
                    <span class="text-sm text-craft-200">Joined {{ $user->created_at->format('F Y') }}</span>
                </div>
            </div>
        </div>
    </div>
    @if ($user->isSeller() && $user->shop)
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-stone-100 bg-craft-50/50 px-6 py-4">
            <p class="text-sm text-stone-600">Your shop: <strong>{{ $user->shop->shop_name }}</strong></p>
            <a href="{{ route('shops.show', $user->shop) }}" class="cn-btn-ghost text-sm">View storefront →</a>
        </div>
    @endif
</div>

<div class="grid gap-8 lg:grid-cols-2">
    <section class="cn-card p-6 sm:p-8">
        <h2 class="font-display text-xl font-semibold text-stone-900">Edit profile</h2>
        <p class="mt-1 text-sm text-stone-500">Update your display name and email.</p>
        <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
            @csrf @method('patch')
            <div>
                <label class="cn-label" for="name">Full name</label>
                <input class="cn-input" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="cn-label" for="email">Email</label>
                <input class="cn-input" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="cn-btn-primary">Save changes</button>
        </form>
    </section>

    <section class="cn-card p-6 sm:p-8">
        <h2 class="font-display text-xl font-semibold text-stone-900">Change password</h2>
        <p class="mt-1 text-sm text-stone-500">Keep your account secure with a strong password.</p>
        <form method="POST" action="{{ route('profile.password.update') }}" class="mt-6 space-y-4">
            @csrf @method('put')
            <div>
                <label class="cn-label" for="current_password">Current password</label>
                <input class="cn-input" id="current_password" name="current_password" type="password" required>
                @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="cn-label" for="password">New password</label>
                <input class="cn-input" id="password" name="password" type="password" required>
                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="cn-label" for="password_confirmation">Confirm password</label>
                <input class="cn-input" id="password_confirmation" name="password_confirmation" type="password" required>
            </div>
            <button type="submit" class="cn-btn-primary">Update password</button>
        </form>
    </section>
</div>

<section class="cn-card mt-8 border-red-200/60 p-6 sm:p-8">
    <h2 class="font-display text-lg font-semibold text-red-800">Danger zone</h2>
    <p class="mt-1 text-sm text-stone-500">Permanently delete your account and all data.</p>
    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-4 max-w-md" onsubmit="return confirm('Delete your account permanently?');">
        @csrf @method('delete')
        <label class="cn-label" for="del_password">Confirm password</label>
        <input class="cn-input mb-3" id="del_password" name="password" type="password" required>
        <button type="submit" class="cn-btn rounded-2xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700">Delete account</button>
    </form>
</section>
@endsection
