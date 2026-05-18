@extends('layouts.app')
@section('title', 'Profile — CraftNest')

@section('content')
<div class="mx-auto max-w-lg rounded-2xl border border-stone-200 bg-white p-8 shadow-sm">
    <h1 class="text-2xl font-bold text-stone-900">Your profile</h1>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        @include('partials.input', ['label' => 'Name', 'name' => 'name', 'value' => $user->name, 'required' => true])
        @include('partials.input', ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'value' => $user->email, 'required' => true])

        <button type="submit" class="rounded-lg bg-amber-700 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-800">
            Save changes
        </button>
    </form>
</div>
@endsection
