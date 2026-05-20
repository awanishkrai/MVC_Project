@extends($layout)
@section('title', 'Notifications — CraftNest')

@if ($layout === 'layouts.admin')
    @section('page-title', 'Notifications')
    @section('page-subtitle', 'Your platform alerts')
@elseif ($layout === 'layouts.seller')
    @section('page-title', 'Notifications')
    @section('page-subtitle', 'Stay updated on your shop')
@endif

@section('content')
@php $isAdmin = $layout === 'layouts.admin'; @endphp

<div @class(['cn-container py-10' => $layout === 'layouts.public'])>
    @if ($layout === 'layouts.public')
        <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="cn-eyebrow">Activity</p>
                <h1 class="font-display text-4xl font-bold text-stone-900">Notifications</h1>
            </div>
            @if (auth()->user()->unreadNotifications()->count() > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="cn-btn-secondary">Mark all as read</button>
                </form>
            @endif
        </div>
    @else
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            @if (auth()->user()->unreadNotifications()->count() > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" @class($isAdmin ? 'rounded-lg bg-craft-600 px-4 py-2 text-sm font-semibold text-white hover:bg-craft-500' : 'cn-btn-secondary')>Mark all as read</button>
                </form>
            @endif
        </div>
    @endif

    @if ($notifications->isEmpty())
        <x-empty-state title="No notifications yet" description="Updates about orders, reviews, and activity will appear here." icon="🔔" />
    @else
        <div @class($isAdmin ? 'space-y-3' : 'cn-card divide-y divide-stone-100 overflow-hidden')>
            @foreach ($notifications as $notification)
                <div @class([
                    'overflow-hidden rounded-2xl border',
                    $isAdmin ? ($notification->read_at ? 'border-slate-800 bg-slate-900/50' : 'border-craft-600/40 bg-slate-900') : '',
                ])>
                    <x-notification-item :notification="$notification" :theme="$isAdmin ? 'dark' : 'light'" />
                </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection
