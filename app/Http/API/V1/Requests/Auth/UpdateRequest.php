<?php

namespace App\Http\API\V1\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['max:255', 'email'],
            'phone' => ['string'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
