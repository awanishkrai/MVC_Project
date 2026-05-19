@extends('layouts.admin')
@section('title', 'Settings')
@section('page-title', 'Account settings')

@section('content')
<div class="mb-6 rounded-2xl border border-slate-800 bg-slate-900 p-5">
    <p class="font-display font-semibold text-white">{{ $user->name }}</p>
    <p class="text-sm text-slate-400">{{ $user->email }} · Administrator</p>
</div>
@include('partials.profile-forms', ['user' => $user])
@endsection
