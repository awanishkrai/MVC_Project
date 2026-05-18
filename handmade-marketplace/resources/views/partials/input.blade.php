@props(['label', 'name', 'type' => 'text', 'required' => false])

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    <label for="{{ $name }}" class="mb-1 block text-sm font-medium text-stone-700">{{ $label }}</label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value ?? '') }}"
        @if($required) required @endif
        class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500"
    >
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
