<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStatusUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isSeller() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'order_status' => ['required', Rule::in(['pending', 'processing', 'shipped', 'delivered'])],
        ];
    }
}
