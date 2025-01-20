<?php

namespace App\Presentation\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

final class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['required', 'string', 'unique:products,sku', 'max:50'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'name.max' => 'Product name cannot exceed 255 characters',
            'description.required' => 'Product description is required',
            'description.max' => 'Product description cannot exceed 1000 characters',
            'price.required' => 'Product price is required',
            'price.min' => 'Price cannot be negative',
            'stock.required' => 'Product stock is required',
            'stock.min' => 'Stock cannot be negative',
            'sku.required' => 'Product SKU is required',
            'sku.unique' => 'This SKU is already in use',
            'sku.max' => 'SKU cannot exceed 50 characters',
        ];
    }
}
