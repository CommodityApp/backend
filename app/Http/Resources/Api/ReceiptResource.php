<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
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
            'rate' => $this->rate,
            'code' => $this->code,
            'name' => $this->name,
            'unit' => $this->unit,
            'producer_name' => $this->producer_name,
            'concentration' => $this->concentration,
            'order_column' => $this->order_column,
            'created_at' => $this->created_at?->formattedCustom(),
            'updated_at' => $this->updated_at?->formattedCustom(),
            'deleted_at' => $this->deleted_at,
            'receipt_raws' => ReceiptRawResource::collection($this->whenLoaded('receiptRaws')),
            'animal_type' => new AnimalTypeResource($this->whenLoaded('animalType')),
            'first_activity' => new ActivityResource($this->whenLoaded('fistActivity')),
        ];
    }
}
