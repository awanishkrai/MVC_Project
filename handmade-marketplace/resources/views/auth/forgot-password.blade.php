@extends('layouts.guest')
@section('title', 'Forgot Password — CraftNest')

@section('content')
<h1 class="font-display text-2xl font-bold text-stone-900 dark:text-white">Forgot password?</h1>
<p class="mt-1 mb-8 text-sm text-stone-500 dark:text-stone-400">Enter your email and we will send a secure reset link.</p>

@if (session('status'))
    <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-200">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-5">
    @csrf

    <div>
        <label for="email" class="cn-label dark:text-stone-300">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
            class="cn-input dark:border-stone-600 dark:bg-stone-800 dark:text-stone-100">
        @error('email')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="cn-btn-primary w-full !py-3">Email reset link</button>
</form>

<p class="mt-8 text-center text-sm text-stone-500 dark:text-stone-400">
    <a href="{{ route('login') }}" class="font-semibold text-craft-700 hover:underline dark:text-craft-400">Back to login</a>
</p>
@endsection
