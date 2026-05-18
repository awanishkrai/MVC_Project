@extends('layouts.guest')
@section('title', 'Reset Password — CraftNest')

@section('content')
<h1 class="mb-2 text-2xl font-bold text-stone-900">Set new password</h1>
<p class="mb-6 text-sm text-stone-500">Choose a strong password for your account.</p>

<form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    @include('partials.input', ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'value' => $email, 'required' => true])

    <div class="mb-4">
        <label for="password" class="mb-1 block text-sm font-medium text-stone-700">New Password</label>
        <input id="password" name="password" type="password" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="password_confirmation" class="mb-1 block text-sm font-medium text-stone-700">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500">
    </div>

    <button type="submit" class="w-full rounded-lg bg-amber-700 py-2.5 text-sm font-semibold text-white hover:bg-amber-800">
        Reset password
    </button>
</form>
@endsection
