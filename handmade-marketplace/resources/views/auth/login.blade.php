@extends('layouts.guest')
@section('title', 'Login — CraftNest')

@section('content')
<h1 class="mb-2 text-2xl font-bold text-stone-900">Welcome back</h1>
<p class="mb-6 text-sm text-stone-500">Sign in to your CraftNest account</p>

<form method="POST" action="{{ route('login') }}" class="space-y-1">
    @csrf

    @include('partials.input', ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'required' => true])

    <div class="mb-4">
        <label for="password" class="mb-1 block text-sm font-medium text-stone-700">Password</label>
        <input id="password" name="password" type="password" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <section class="mb-6 flex items-center justify-between text-sm">
        <label class="flex items-center gap-2 text-stone-600">
            <input type="checkbox" name="remember" class="rounded border-stone-300 text-amber-700 focus:ring-amber-500">
            Remember me
        </label>
        <a href="{{ route('password.request') }}" class="text-amber-800 hover:underline">Forgot password?</a>
    </section>

    <button type="submit" class="w-full rounded-lg bg-amber-700 py-2.5 text-sm font-semibold text-white hover:bg-amber-800">
        Log in
    </button>
</form>

<p class="mt-6 text-center text-sm text-stone-500">
    New to CraftNest?
    <a href="{{ route('register') }}" class="font-medium text-amber-800 hover:underline">Create an account</a>
</p>
@endsection
