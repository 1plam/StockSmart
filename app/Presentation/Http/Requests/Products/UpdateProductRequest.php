<?php

namespace App\Presentation\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:1000'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'sku' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('products', 'sku')->ignore($this->route('id'))
            ],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'Product name cannot exceed 255 characters',
            'description.max' => 'Product description cannot exceed 1000 characters',
            'price.min' => 'Price cannot be negative',
            'stock.min' => 'Stock cannot be negative',
            'sku.unique' => 'This SKU is already in use',
            'sku.max' => 'SKU cannot exceed 50 characters',
        ];
    }
}
