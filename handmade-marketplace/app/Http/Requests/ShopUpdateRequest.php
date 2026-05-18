<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isSeller() && $this->user()?->shop !== null;
    }

    public function rules(): array
    {
        return [
            'shop_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'location' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'shop_name.required' => 'Shop name is required.',
            'logo.image' => 'Logo must be an image file.',
            'logo.max' => 'Logo must not be larger than 2MB.',
        ];
    }
}
