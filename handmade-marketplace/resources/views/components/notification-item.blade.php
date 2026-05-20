@props(['notification', 'theme' => 'light', 'compact' => false])

@php
    $data = $notification->data;
    $isDark = $theme === 'dark';
    $unread = $notification->read_at === null;
@endphp

<a href="{{ route('notifications.read', $notification->id) }}"
   @class([
       'block px-4 py-3 transition',
       'bg-craft-50/80' => $unread && ! $isDark,
       'bg-slate-800/50' => $unread && $isDark,
       'hover:bg-stone-50' => ! $isDark,
       'hover:bg-slate-800' => $isDark,
   ])>
    <p @class(['text-sm font-semibold', 'text-stone-900' => ! $isDark, 'text-white' => $isDark])>{{ $data['title'] ?? 'Notification' }}</p>
    <p @class(['mt-0.5 text-xs leading-relaxed', 'text-stone-600' => ! $isDark, 'text-slate-400' => $isDark, 'line-clamp-2' => $compact])>{{ $data['message'] ?? '' }}</p>
    <p @class(['mt-1 text-[10px]', 'text-stone-400' => ! $isDark, 'text-slate-500' => $isDark])>{{ $notification->created_at->diffForHumans() }}</p>
</a>
