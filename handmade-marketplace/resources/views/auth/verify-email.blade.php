@extends('layouts.guest')
@section('title', 'Verify Email — CraftNest')

@section('content')
<h1 class="mb-2 text-2xl font-bold text-stone-900">Verify your email</h1>
<p class="mb-6 text-sm text-stone-500">
    Thanks for signing up! Click the link in your email, or request a new one below.
</p>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit" class="w-full rounded-lg bg-amber-700 py-2.5 text-sm font-semibold text-white hover:bg-amber-800">
        Resend verification email
    </button>
</form>
@endsection
