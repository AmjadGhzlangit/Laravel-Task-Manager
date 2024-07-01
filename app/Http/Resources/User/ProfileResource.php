<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 **/
class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'has_verified_email' => $this->hasVerifiedEmail(),
        ];
    }
}
