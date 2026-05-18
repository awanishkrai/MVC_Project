@extends('layouts.guest')
@section('title', 'Confirm Password — CraftNest')

@section('content')
<h1 class="mb-2 text-2xl font-bold text-stone-900">Confirm password</h1>
<p class="mb-6 text-sm text-stone-500">This is a secure area. Please confirm your password.</p>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <div class="mb-4">
        <label for="password" class="mb-1 block text-sm font-medium text-stone-700">Password</label>
        <input id="password" name="password" type="password" required
            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm">
        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <button type="submit" class="w-full rounded-lg bg-amber-700 py-2.5 text-sm font-semibold text-white hover:bg-amber-800">
        Confirm
    </button>
</form>
@endsection
