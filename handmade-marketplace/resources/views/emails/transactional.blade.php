<x-mail::message>
# {{ $heading }}

{{ $body }}

@if ($actionUrl)
<x-mail::button :url="$actionUrl">
{{ $actionLabel }}
</x-mail::button>
@endif

Thanks,<br>
{{ config('app.name', 'CraftNest') }}
</x-mail::message>
