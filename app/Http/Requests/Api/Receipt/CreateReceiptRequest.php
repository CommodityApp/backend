<?php

namespace App\Http\Requests\Api\Receipt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReceiptRequest extends FormRequest
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
            'rate' => 'required|numeric',
            'code' => ['required', Rule::unique('receipts', 'code')],
            'name' => 'required|string|max:255',
            'unit' => 'present|max:255',
            'producer_name' => 'present|max:255',
            'concentration' => 'required|numeric|min:0',

            'receipt_raws' => 'present|array',
            'receipt_raws.*.raw_id' => 'required|distinct|exists:raws,id',
            'receipt_raws.*.ratio' => 'required|numeric|min:0',
        ];
    }
}
