<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'date' => $this->date?->formattedCustom('Y-m-d'),
            'amount' => $this->amount,
            'price' => $this->price,
            'ratio' => $this->ratio,
            'error' => $this->error,
            'batch_quantity' => $this->batch_quantity,
            'batch_inputs' => $this->batch_inputs,
            'calculated_amount' => $this->calculated_amount,
            'calculated_amount_with_error' => $this->calculated_amount_with_error,
            'created_at' => $this->created_at?->formattedCustom(),
            'updated_at' => $this->updated_at?->formattedCustom(),
            'order_calculated_raws' => OrderCalculatedRawResource::collection($this->whenLoaded('orderCalculatedRaws')),

            'receipt' => new ReceiptResource($this->whenLoaded('receipt')),
            'client' => new ClientResource($this->whenLoaded('client')),
        ];
    }
}
