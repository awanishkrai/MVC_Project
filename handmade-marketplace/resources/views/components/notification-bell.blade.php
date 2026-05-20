@props(['theme' => 'light'])

@auth
@php
    $unread = auth()->user()->unreadNotifications()->count();
    $recent = auth()->user()->notifications()->latest()->take(5)->get();
    $isDark = $theme === 'dark';
@endphp

<details class="relative">
    <summary @class([
        'relative flex cursor-pointer list-none items-center justify-center rounded-full p-2 transition [&::-webkit-details-marker]:hidden',
        'text-stone-600 hover:bg-stone-100' => ! $isDark,
        'text-slate-300 hover:bg-slate-800' => $isDark,
    ])>
        <span class="sr-only">Notifications</span>
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        @if ($unread > 0)
            <span class="absolute right-0.5 top-0.5 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white">{{ $unread > 9 ? '9+' : $unread }}</span>
        @endif
    </summary>

    <div @class([
        'absolute right-0 z-50 mt-2 w-80 overflow-hidden rounded-2xl border shadow-xl',
        'border-stone-200 bg-white' => ! $isDark,
        'border-slate-700 bg-slate-900' => $isDark,
    ])>
        <div @class(['flex items-center justify-between border-b px-4 py-3', $isDark ? 'border-slate-800' : 'border-stone-100'])>
            <p @class(['text-sm font-semibold', 'text-stone-900' => ! $isDark, 'text-white' => $isDark])>Notifications</p>
            @if ($unread > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" @class(['text-xs font-medium', 'text-craft-700' => ! $isDark, 'text-craft-400' => $isDark])>Mark all read</button>
                </form>
            @endif
        </div>
        <ul class="max-h-72 overflow-y-auto">
            @forelse ($recent as $notification)
                <li @class(['border-b', $isDark ? 'border-slate-800' : 'border-stone-100'])>
                    <x-notification-item :notification="$notification" :theme="$theme" compact />
                </li>
            @empty
                <li class="px-4 py-6 text-center text-sm text-stone-500">You're all caught up.</li>
            @endforelse
        </ul>
        <div @class(['border-t px-4 py-2 text-center', $isDark ? 'border-slate-800' : 'border-stone-100'])>
            <a href="{{ route('notifications.index') }}" @class(['text-xs font-semibold', 'text-craft-700' => ! $isDark, 'text-craft-400' => $isDark])>View all →</a>
        </div>
    </div>
</details>
@endauth
