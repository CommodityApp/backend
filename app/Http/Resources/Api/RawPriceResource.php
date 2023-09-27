<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RawPriceResource extends JsonResource
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
            'price' => $this->price,
            'name' => $this->name,
            'code' => $this->code,
            'unit' => $this->unit,
            'created_at' => $this->created_at->formattedCustom(),
            'updated_at' => $this->updated_at->formattedCustom(),
        ];
    }
}
