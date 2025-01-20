<?php

namespace App\Presentation\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

final class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ];
    }
    
    public function messages(): array
    {
        return [
            'email.required' => 'An email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email address must not exceed 255 characters.',
            'password.required' => 'A password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
        ];
    }
}
