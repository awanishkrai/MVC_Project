<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', Rule::in([1, 2, 3, 4, 5])],
            'title' => ['nullable', 'string', 'max:120'],
            'comment' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }
}
