@props(['type' => 'success', 'message' => null])

@php
    $styles = [
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-900',
        'error' => 'border-red-200 bg-red-50 text-red-900',
        'info' => 'border-sky-200 bg-sky-50 text-sky-900',
    ];
    $icons = [
        'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'error' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    ];
@endphp

<div data-alert {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-2xl border px-4 py-3 shadow-sm transition '.($styles[$type] ?? $styles['success'])]) }} role="alert">
    <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icons[$type] ?? $icons['success'] }}"/></svg>
    <div class="flex-1 text-sm font-medium">
        @if ($message){{ $message }}@else{{ $slot }}@endif
    </div>
    <button type="button" data-dismiss class="rounded-lg p-1 opacity-60 hover:opacity-100" aria-label="Dismiss">✕</button>
</div>
