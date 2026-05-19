@extends('layouts.public')
@section('title', 'Checkout — CraftNest')

@section('content')
<div class="cn-container py-10">
    <div class="mb-8">
        <p class="cn-eyebrow">Secure checkout</p>
        <h1 class="font-display text-4xl font-bold text-stone-900">Complete your order</h1>
        <p class="mt-2 text-stone-500">Enter delivery details and choose how you'd like to pay.</p>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" class="grid gap-8 lg:grid-cols-3">
        @csrf

        <div class="space-y-6 lg:col-span-2">
            {{-- Shipping --}}
            <section class="cn-card p-6 sm:p-8">
                <h2 class="flex items-center gap-2 font-display text-xl font-bold text-stone-900">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-craft-100 text-sm">1</span>
                    Delivery details
                </h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="cn-label" for="shipping_name">Full name</label>
                        <input type="text" id="shipping_name" name="shipping_name" value="{{ old('shipping_name', $user->name) }}" class="cn-input" required>
                        @error('shipping_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="cn-label" for="shipping_phone">Phone</label>
                        <input type="tel" id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone') }}" class="cn-input" placeholder="+1 555 000 0000" required>
                        @error('shipping_phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="cn-label" for="shipping_pincode">Pincode</label>
                        <input type="text" id="shipping_pincode" name="shipping_pincode" value="{{ old('shipping_pincode') }}" class="cn-input" required>
                        @error('shipping_pincode')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="cn-label" for="shipping_address">Street address</label>
                        <textarea id="shipping_address" name="shipping_address" rows="2" class="cn-input" required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="cn-label" for="shipping_city">City</label>
                        <input type="text" id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" class="cn-input" required>
                        @error('shipping_city')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="cn-label" for="shipping_state">State</label>
                        <input type="text" id="shipping_state" name="shipping_state" value="{{ old('shipping_state') }}" class="cn-input" required>
                        @error('shipping_state')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            {{-- Payment --}}
            <section class="cn-card p-6 sm:p-8">
                <h2 class="flex items-center gap-2 font-display text-xl font-bold text-stone-900">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-craft-100 text-sm">2</span>
                    Payment method
                </h2>
                <div class="mt-6 space-y-3">
                    <x-payment-method-card value="cod" label="Cash on Delivery" description="Pay when your handmade order arrives at your door." icon="💵" />
                    <x-payment-method-card value="card" label="Card Payment (Demo)" description="Simulated payment — no real charges. For project demonstration only." icon="💳" />
                </div>
                @error('payment_method')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror

                <div id="card-fields" class="mt-6 hidden rounded-2xl border border-dashed border-craft-200 bg-craft-50/50 p-5">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-wider text-stone-500">Demo card details</p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="cn-label" for="card_number">Card number</label>
                            <input type="text" id="card_number" name="card_number" value="{{ old('card_number') }}" maxlength="16" placeholder="4242424242424242" class="cn-input">
                            @error('card_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="cn-label" for="card_expiry">Expiry (MM/YY)</label>
                            <input type="text" id="card_expiry" name="card_expiry" value="{{ old('card_expiry') }}" placeholder="12/28" class="cn-input">
                            @error('card_expiry')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="cn-label" for="card_cvv">CVV</label>
                            <input type="text" id="card_cvv" name="card_cvv" value="{{ old('card_cvv') }}" maxlength="3" placeholder="123" class="cn-input">
                            @error('card_cvv')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-stone-400">This is a simulation only — no payment gateway is connected.</p>
                </div>
            </section>
        </div>

        <div>
            <x-checkout-summary
                :items="$items"
                :subtotal="$subtotal"
                :shipping="$shipping"
                :total="$total"
                :show-checkout="false"
            >
                <button type="submit" class="cn-btn-primary w-full">Place order</button>
                <a href="{{ route('cart.index') }}" class="mt-2 block text-center text-sm text-stone-500 hover:text-craft-700">← Back to cart</a>
            </x-checkout-summary>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cardFields = document.getElementById('card-fields');
        const radios = document.querySelectorAll('input[name="payment_method"]');

        function toggleCard() {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            cardFields.classList.toggle('hidden', !selected || selected.value !== 'card');
        }

        radios.forEach(r => r.addEventListener('change', toggleCard));
        toggleCard();
    });
</script>
@endsection
