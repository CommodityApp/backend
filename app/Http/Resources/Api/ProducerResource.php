<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProducerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at?->formattedCustom(),
            'updated_at' => $this->updated_at?->formattedCustom(),
            'country' => new CountryResource($this->whenLoaded('country')),
            'first_activity' => new ActivityResource($this->whenLoaded('firstActivity')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
