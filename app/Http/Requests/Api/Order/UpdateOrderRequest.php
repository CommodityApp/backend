<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'receipt_id' => 'required|exists:receipts,id',
            'batch_quantity' => 'required|numeric|min:1|max:30',
            'batch_inputs' => 'required|array|size:'.$this->input('batch_quantity'),
            'batch_inputs.*' => 'required|numeric',
            'amount' => 'required|numeric|size:'.array_sum($this->input('batch_inputs', [])),
            'error' => 'required|numeric',
            'date' => 'required|date',
        ];
    }
}
