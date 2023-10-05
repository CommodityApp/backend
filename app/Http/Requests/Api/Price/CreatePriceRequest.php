<?php

namespace App\Http\Requests\Api\Price;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePriceRequest extends FormRequest
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
            'name' => ['required', 'max:255', Rule::unique('prices', 'name')->whereNull('deleted_at')],
            'code' => ['present', 'nullable', Rule::unique('prices', 'code')],
            'unit' => 'present|nullable|max:255',
            'price_raws' => 'present|array',
            'price_raws.*.raw_id' => 'required|distinct|exists:raws,id',
            'price_raws.*.price' => 'required|numeric|min:0',
        ];
    }
}
