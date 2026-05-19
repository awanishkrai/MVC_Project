@props(['value', 'label', 'description', 'icon' => '💳'])

<label {{ $attributes->merge(['class' => 'block cursor-pointer']) }}>
    <input type="radio" name="payment_method" value="{{ $value }}" class="peer sr-only" @checked(old('payment_method', 'cod') === $value)>
    <div class="cn-card flex items-start gap-4 p-4 transition peer-checked:border-craft-500 peer-checked:ring-2 peer-checked:ring-craft-200 hover:border-craft-300">
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-craft-50 text-xl">{{ $icon }}</span>
        <div>
            <p class="font-semibold text-stone-900">{{ $label }}</p>
            <p class="mt-0.5 text-sm text-stone-500">{{ $description }}</p>
        </div>
        <span class="ml-auto mt-1 hidden h-5 w-5 rounded-full border-2 border-stone-300 peer-checked:border-craft-600 peer-checked:bg-craft-600 peer-checked:[box-shadow:inset_0_0_0_3px_white] sm:block"></span>
    </div>
</label>
