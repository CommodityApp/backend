<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'subject_id' => $this->subject_id,
            'subject_type' => $this->subject_type->getLabel(),
            'description' => $this->description,
            'created_at' => $this->created_at?->formattedCustom(),
            'causer' => new UserResource($this->whenLoaded('causer')),

        ];
    }
}
