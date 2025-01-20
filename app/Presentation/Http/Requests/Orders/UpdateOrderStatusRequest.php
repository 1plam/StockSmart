<?php

namespace App\Presentation\Http\Requests\Orders;

use App\Domain\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateOrderStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(OrderStatus::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Order status is required',
            'status.enum' => 'Invalid order status',
        ];
    }

    public function getStatus(): OrderStatus
    {
        return OrderStatus::from($this->validated('status'));
    }
}
