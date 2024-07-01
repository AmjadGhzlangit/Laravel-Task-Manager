<?php

namespace App\Http\Resources\Task;

use App\Models\Task;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Task
 */
class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => [
                'key' => $this->status->value,
                'name' => $this->status->name,
            ],
            'images' => $this->getImages(),
            'created_at' => $this->created_at->format('Y/m/d:H:i'),
            'updated_at' => $this->updated_at->format('Y/m/d:H:i'),
        ];

    }

    /**
     * Get the URLs of the images associated with the task.
     *
     * @return array
     */
    protected function getImages()
    {
        return $this->getMedia('images')->map(function ($media) {
            return $media->getUrl();
        })->toArray();
    }
}
