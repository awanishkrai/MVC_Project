<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_state' => ['required', 'string', 'max:100'],
            'shipping_pincode' => ['required', 'string', 'max:10'],
            'payment_method' => ['required', Rule::in(['cod', 'card'])],
            'card_number' => ['required_if:payment_method,card', 'nullable', 'string', 'size:16'],
            'card_expiry' => ['required_if:payment_method,card', 'nullable', 'string', 'regex:/^\d{2}\/\d{2}$/'],
            'card_cvv' => ['required_if:payment_method,card', 'nullable', 'string', 'size:3'],
        ];
    }

    public function messages(): array
    {
        return [
            'shipping_name.required' => 'Please enter your full name.',
            'shipping_phone.required' => 'Phone number is required.',
            'shipping_address.required' => 'Delivery address is required.',
            'payment_method.required' => 'Please select a payment method.',
            'card_number.required_if' => 'Card number is required for card payment.',
            'card_expiry.required_if' => 'Expiry date is required (MM/YY).',
            'card_cvv.required_if' => 'CVV is required for card payment.',
        ];
    }
}
