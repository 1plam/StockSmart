<?php

namespace App\Presentation\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'notes' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'notes.max' => 'Notes cannot exceed 1000 characters',
        ];
    }
}
