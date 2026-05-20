@extends('layouts.guest')
@section('title', 'Login — CraftNest')

@section('content')
<h1 class="font-display text-2xl font-bold text-stone-900 dark:text-white">Welcome back</h1>
<p class="mt-1 mb-8 text-sm text-stone-500 dark:text-stone-400">Sign in to continue shopping or managing your shop.</p>

<form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf

    <div>
        <label for="email" class="cn-label dark:text-stone-300">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100 dark:focus:ring-craft-900">
        @error('email')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="cn-label dark:text-stone-300">Password</label>
        <input id="password" name="password" type="password" required
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100 dark:focus:ring-craft-900">
        @error('password')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-between text-sm">
        <label class="flex items-center gap-2 text-stone-600 dark:text-stone-400">
            <input type="checkbox" name="remember" class="rounded border-stone-300 text-craft-700 focus:ring-craft-500 dark:border-stone-600 dark:bg-stone-800">
            Remember me
        </label>
        <a href="{{ route('password.request') }}" class="font-medium text-craft-700 hover:text-craft-800 dark:text-craft-400 dark:hover:text-craft-300">Forgot password?</a>
    </div>

    <button type="submit" class="cn-btn-primary w-full !py-3">Log in</button>
</form>

<p class="mt-8 text-center text-sm text-stone-500 dark:text-stone-400">
    New to CraftNest?
    <a href="{{ route('register') }}" class="font-semibold text-craft-700 hover:underline dark:text-craft-400">Create an account</a>
</p>
@endsection
