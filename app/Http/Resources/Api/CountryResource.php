<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'country_code' => $this->country_code,
            'iso_3166_2' => $this->iso_3166_2,
            'iso_3166_3' => $this->iso_3166_3,
            'created_at' => $this->created_at->formattedCustom(),
            'updated_at' => $this->updated_at->formattedCustom(),
        ];
    }
}
