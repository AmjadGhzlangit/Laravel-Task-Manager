<?php

namespace App\Http\API\V1\Requests\Task;

use App\Enum\Task\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'description' => ['string'],
            'status' => [new Enum(TaskStatus::class)],
            'images.*' => ['image', 'mimes:jpg,jpeg,png|max:2048'],
        ];
    }
}
