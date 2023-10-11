<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RawResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'unit' => $this->unit,
            'concentration' => $this->concentration,
            'batch_number' => $this->batch_number,
            'order_column' => $this->order_column,
            'created_at' => $this->created_at?->formattedCustom(),
            'updated_at' => $this->updated_at?->formattedCustom(),
            'deleted_at' => $this->deleted_at,
            // 'raw_type_id' => $this->raw_type_id,
            // 'producer_id' => $this->producer_id,
            // 'bunker_id' => $this->bunker_id,
            // 'country_id' => $this->country_id,
            'last_raw_price' => new RawPriceResource($this->whenLoaded('lastRawPrice')),
            'raw_prices' => RawPriceResource::collection($this->whenLoaded('rawPrices')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'bunker' => new BunkerResource($this->whenLoaded('bunker')),
            'producer' => new ProducerResource($this->whenLoaded('producer')),
            'raw_type' => new RawTypeResource($this->whenLoaded('rawType')),
            'first_activity' => new ActivityResource($this->whenLoaded('firstActivity')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
        ];
    }
}
