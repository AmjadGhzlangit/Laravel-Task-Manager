<?php

namespace App\Http\API\V1\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDeviceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'udid' => ['required'],
            'fcm_token' => ['required'],
        ];
    }
}
