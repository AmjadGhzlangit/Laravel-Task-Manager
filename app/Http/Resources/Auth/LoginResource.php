<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\User\ProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\NewAccessToken;

/**
 * @mixin NewAccessToken
 */
class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'token_type' => 'bearer',
            'access_token' => $this->plainTextToken,
            'profile' => new ProfileResource($this->accessToken->tokenable),
        ];
    }
}
