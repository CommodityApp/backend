<?php

namespace App\Http\Requests\Api\Ration;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRationRequest extends FormRequest
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
            'receipt_id' => 'required|exists:receipts,id',
            'name' => ['required', 'max:255', Rule::unique('rations', 'name')->whereNull('deleted_at')],
            'code' => ['required', Rule::unique('rations', 'code')],
            'unit' => 'present|nullable|max:255',
            'producer_name' => 'present|nullable|max:255',

            'ration_raws' => 'present|array',
            'ration_raws.*.raw_id' => 'required|distinct|exists:raws,id',
            'ration_raws.*.ratio' => 'required|numeric|min:0',
        ];
    }
}
