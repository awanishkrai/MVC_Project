@extends('layouts.guest')
@section('title', 'Reset Password — CraftNest')

@section('content')
<h1 class="font-display text-2xl font-bold text-stone-900 dark:text-white">Set new password</h1>
<p class="mt-1 mb-8 text-sm text-stone-500 dark:text-stone-400">Choose a strong password for your CraftNest account.</p>

<form method="POST" action="{{ route('password.store') }}" class="space-y-5">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label for="email" class="cn-label dark:text-stone-300">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
        @error('email')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="cn-label dark:text-stone-300">New password</label>
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

    <button type="submit" class="cn-btn-primary w-full !py-3">Reset password</button>
</form>
@endsection
