@extends('layouts.seller')
@section('title', 'Settings')
@section('page-title', 'Account settings')
@section('page-subtitle', 'Profile & security')

@section('content')
<div class="mb-6 cn-card p-5">
    <div class="flex items-center gap-4">
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-craft-100 text-xl font-bold text-craft-800">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div>
            <p class="font-display font-semibold text-stone-900">{{ $user->name }}</p>
            <p class="text-sm text-stone-500">{{ $user->email }} · Seller</p>
        </div>
    </div>
</div>
@include('partials.profile-forms', ['user' => $user])
@endsection
