<?php

namespace App\Http\API\V1\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'current_password:sanctum'],
            'new_password' => ['required', 'min:6'],
        ];
    }
}
