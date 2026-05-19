@extends('layouts.admin')
@section('page-title', $title ?? 'Coming soon')

@section('content')
<div class="rounded-2xl border border-dashed border-slate-700 bg-slate-900/50 px-8 py-16 text-center">
    <p class="text-4xl">🚧</p>
    <h2 class="mt-4 font-display text-xl font-semibold text-white">{{ $title }}</h2>
    <p class="mt-2 text-slate-400">{{ $module }} — planned for a future module.</p>
    <a href="{{ route('admin.dashboard') }}" class="mt-6 inline-block rounded-xl bg-craft-600 px-5 py-2 text-sm font-semibold text-white">Back to dashboard</a>
</div>
@endsection
