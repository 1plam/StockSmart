<?php

namespace App\Presentation\Http\Requests\DiscountCodes;

use Illuminate\Foundation\Http\FormRequest;

class ApplyDiscountCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'discount_code' => ['required', 'string', 'min:3', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'discount_code.required' => 'Please enter a discount code.',
            'discount_code.min' => 'Discount code must be at least 3 characters.',
            'discount_code.max' => 'Discount code cannot exceed 50 characters.',
        ];
    }
}
