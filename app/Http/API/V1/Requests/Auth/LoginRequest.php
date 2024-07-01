<?php

namespace App\Http\API\V1\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', Rule::exists('users', 'email')],
            'password' => ['required', 'min:8'],
            'udid' => ['string'],
            'fcm_token' => ['required_with:udid'],
        ];
    }
}
