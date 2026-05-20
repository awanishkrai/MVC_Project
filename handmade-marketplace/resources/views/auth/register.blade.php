@extends('layouts.guest')
@section('title', 'Register — CraftNest')

@section('content')
<h1 class="font-display text-2xl font-bold text-stone-900 dark:text-white">Join CraftNest</h1>
<p class="mt-1 mb-8 text-sm text-stone-500 dark:text-stone-400">Create your buyer or seller account in minutes.</p>

<form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf

    <div>
        <label for="name" class="cn-label dark:text-stone-300">Full name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
        @error('name')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="cn-label dark:text-stone-300">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
        @error('email')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="cn-label dark:text-stone-300">Password</label>
        <input id="password" name="password" type="password" required
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
        @error('password')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="cn-label dark:text-stone-300">Confirm password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
    </div>

    <div>
        <label for="role" class="cn-label dark:text-stone-300">I want to register as</label>
        <select id="role" name="role" required
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
            <option value="">— Select role —</option>
            <option value="buyer" @selected(old('role') === 'buyer')>Buyer — browse &amp; purchase</option>
            <option value="seller" @selected(old('role') === 'seller')>Seller — open a handmade shop</option>
        </select>
        @error('role')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="cn-btn-primary w-full !py-3">Create account</button>
</form>

<p class="mt-8 text-center text-sm text-stone-500 dark:text-stone-400">
    Already have an account?
    <a href="{{ route('login') }}" class="font-semibold text-craft-700 hover:underline dark:text-craft-400">Log in</a>
</p>
@endsection
