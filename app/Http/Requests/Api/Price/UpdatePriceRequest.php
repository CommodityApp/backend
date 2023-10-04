<?php

namespace App\Http\Requests\Api\Price;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePriceRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'code' => ['present', 'nullable', Rule::unique('prices', 'code')->ignore($this->price->id)],
            'price_raws' => 'present|array',
            'price_raws.*.raw_id' => 'required|distinct|exists:raws,id',
            'price_raws.*.price' => 'required|numeric|min:0',
        ];
    }
}
