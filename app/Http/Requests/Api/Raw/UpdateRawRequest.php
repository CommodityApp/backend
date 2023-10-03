<?php

namespace App\Http\Requests\Api\Raw;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRawRequest extends FormRequest
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
            'code' => ['present', Rule::unique('raws', 'code')->ignore($this->raw->id)],
            'name' => 'required|string|max:255',
            'unit' => 'present|max:255',
            'concentration' => ['present', 'numeric', 'min:0'],
            'batch_number' => 'present|max:255',
            'producer_id' => 'present|exists:producers,id',
            'country_id' => 'present|exists:countries,id',
            'raw_type_id' => 'present|exists:raw_types,id',
            'bunker_id' => 'present|exists:bunkers,id',
        ];
    }
}
