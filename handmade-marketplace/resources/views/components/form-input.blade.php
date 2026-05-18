@props(['label', 'name', 'type' => 'text', 'value' => null, 'required' => false, 'hint' => null])

<div {{ $attributes->only('class')->merge(['class' => 'mb-4']) }}>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-stone-700">{{ $label }}</label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ $attributes->except('class')->merge(['class' => 'w-full rounded-xl border border-stone-300 bg-white px-3.5 py-2.5 text-sm text-stone-800 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20']) }}
    >
    @if ($hint)
        <p class="mt-1 text-xs text-stone-500">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
