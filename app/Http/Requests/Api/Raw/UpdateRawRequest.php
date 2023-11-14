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
            'name' => ['required', 'string', 'max:255', Rule::unique('raws', 'name')->whereNull('deleted_at')->ignore($this->raw->id)],
            'code' => ['nullable', Rule::unique('raws', 'code')->ignore($this->raw->id)],
            'unit' => 'nullable|max:255',
            'concentration' => ['nullable', 'numeric', 'min:0'],
            'batch_number' => 'nullable|max:255',
            'producer_id' => 'nullable|exists:producers,id',
            'country_id' => 'nullable|exists:countries,id',
            'raw_type_id' => 'nullable|exists:raw_types,id',
            'bunker_id' => 'nullable|exists:bunkers,id',
            'description' => 'nullable',
        ];
    }
}
