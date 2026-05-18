@extends('layouts.guest')
@section('title', 'Register — CraftNest')

@section('content')
<h1 class="mb-2 text-2xl font-bold text-stone-900">Join CraftNest</h1>
<p class="mb-6 text-sm text-stone-500">Create your buyer or seller account</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    @include('partials.input', ['label' => 'Full Name', 'name' => 'name', 'required' => true])
    @include('partials.input', ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'required' => true])

    <div class="mb-4">
        <label for="password" class="mb-1 block text-sm font-medium text-stone-700">Password</label>
        <input id="password" name="password" type="password" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="mb-1 block text-sm font-medium text-stone-700">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
    </div>

    <section class="mb-6">
        <label for="role" class="mb-1 block text-sm font-medium text-stone-700">I want to register as</label>
        <select id="role" name="role" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
            <option value="">— Select role —</option>
            <option value="buyer" @selected(old('role') === 'buyer')>Buyer — browse &amp; purchase</option>
            <option value="seller" @selected(old('role') === 'seller')>Seller — open a handmade shop</option>
        </select>
        @error('role')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </section>

    <button type="submit" class="w-full rounded-lg bg-amber-700 py-2.5 text-sm font-semibold text-white hover:bg-amber-800">
        Create account
    </button>
</form>

<p class="mt-6 text-center text-sm text-stone-500">
    Already have an account?
    <a href="{{ route('login') }}" class="font-medium text-amber-800 hover:underline">Log in</a>
</p>
@endsection
