<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all guests to register
    }

    /**
     * Validation rules for user registration.
     *
     * NOTE: We cannot use `unique:users` with MongoDB because Laravel's
     * built-in unique rule uses SQL. We do a manual MongoDB query instead.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // MongoDB-compatible unique check — replaces `unique:users`
                function ($attribute, $value, $fail) {
                    if (User::where('email', $value)->exists()) {
                        $fail('The '.$attribute.' address is already registered.');
                    }
                }
            ],
            'password' => 'required|string|min:8|confirmed',
            // password_confirmation is implicitly validated by `confirmed` above
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'      => 'Please enter your full name.',
            'name.min'           => 'Your name must be at least 2 characters.',
            'email.required'     => 'An email address is required to register.',
            'email.email'        => 'Please enter a valid email address.',
            'password.required'  => 'A password is required.',
            'password.min'       => 'Your password must be at least 8 characters.',
            'password.confirmed' => 'The password and confirmation do not match.',
        ];
    }
}
