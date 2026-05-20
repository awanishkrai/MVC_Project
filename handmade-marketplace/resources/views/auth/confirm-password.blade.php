@extends('layouts.guest')
@section('title', 'Confirm Password — CraftNest')

@section('content')
<h1 class="font-display text-2xl font-bold text-stone-900 dark:text-white">Confirm password</h1>
<p class="mt-1 mb-8 text-sm text-stone-500 dark:text-stone-400">This is a secure area. Please confirm your password to continue.</p>

<form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
    @csrf
    <div>
        <label for="password" class="cn-label dark:text-stone-300">Password</label>
        <input id="password" name="password" type="password" required
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
        @error('password')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="cn-btn-primary w-full !py-3">Confirm</button>
</form>
@endsection
