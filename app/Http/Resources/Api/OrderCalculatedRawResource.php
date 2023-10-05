<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCalculatedRawResource extends JsonResource
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
            'ratio' => $this->ratio,
            'calculated_amount' => $this->calculated_amount,
            'calculated_amount_with_error' => $this->calculated_amount_with_error,
            'receipt_raw' => new ReceiptRawResource($this->whenLoaded('receiptRaw')),
        ];
    }
}
