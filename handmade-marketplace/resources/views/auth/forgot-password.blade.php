@extends('layouts.guest')
@section('title', 'Forgot Password — CraftNest')

@section('content')
<h1 class="mb-2 text-2xl font-bold text-stone-900">Forgot password?</h1>
<p class="mb-6 text-sm text-stone-500">Enter your email and we will send a reset link.</p>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    @include('partials.input', ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'required' => true])

    <button type="submit" class="w-full rounded-lg bg-amber-700 py-2.5 text-sm font-semibold text-white hover:bg-amber-800">
        Email reset link
    </button>
</form>

<p class="mt-6 text-center text-sm text-stone-500">
    <a href="{{ route('login') }}" class="font-medium text-amber-800 hover:underline">Back to login</a>
</p>
@endsection
