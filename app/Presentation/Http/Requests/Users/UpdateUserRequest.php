<?php

namespace App\Presentation\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => [
                'sometimes',
                'required',
                'confirmed',
                'min:8',
            ],
            'password_confirmation' => [
                'sometimes',
                'required_with:password',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Your name is required when updating.',
            'name.min' => 'Your name must be at least 2 characters long.',
            'name.max' => 'Your name must not exceed 255 characters.',

            'email.required' => 'An email address is required when updating.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email address must not exceed 255 characters.',
            'email.unique' => 'This email address is already in use.',

            'password.required' => 'A new password is required when updating.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'New password must be at least 8 characters long.',

            'password_confirmation.required_with' => 'Please confirm your new password.',
        ];
    }
}
