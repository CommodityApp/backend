<?php

namespace App\Http\Requests\Api\Receipt;

use App\Rules\ConcentrationSumOfRatios;
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
            'name' => ['required', 'max:255', Rule::unique('receipts', 'name')->whereNull('deleted_at')],
            'code' => ['required', Rule::unique('receipts', 'code')],
            'rate' => 'required|numeric',
            'unit' => 'present|nullable|max:255',
            'producer_name' => 'present|nullable|max:255',
            'concentration' => ['required', 'numeric', 'min:0', new ConcentrationSumOfRatios],
            'animal_type_id' => 'present|nullable|exists:animal_types,id',

            'receipt_raws' => 'present|array',
            'receipt_raws.*.raw_id' => 'required|distinct|exists:raws,id',
            'receipt_raws.*.ratio' => 'required|numeric|min:0',
        ];
    }
}
