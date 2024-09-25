<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'send-password' => ['nullable', 'in:1'],
            'password' => ['required_unless:send-password,1', Password::min(6)],
            'type' => ['required', Rule::in(User::getEnums('type'))],
            'is_active' => ['required', 'in:0,1'],
        ];
    }

    public function messages()
    {
        return [
            'password.required_unless' => 'Password is required when not sending on email.'
        ];
    }
}
