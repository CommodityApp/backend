<?php

namespace App\Http\Requests\Api\Ration;

use App\Rules\ConcentrationSumOfRatios;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRationRequest extends FormRequest
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
            'name' => ['required', 'max:255', Rule::unique('rations', 'name')->whereNull('deleted_at')->ignore($this->ration->id)],
            'code' => ['required', Rule::unique('rations', 'code')->ignore($this->ration->id)],
            'rate' => 'required|numeric',
            'unit' => 'present|nullable|max:255',
            'producer_name' => 'present|nullable|max:255',
            'concentration' => ['required', 'numeric', 'min:0', new ConcentrationSumOfRatios('ration_raws')],
            'animal_type_id' => 'present|nullable|exists:animal_types,id',

            'ration_raws' => 'present|array',
            'ration_raws.*.raw_id' => 'required|distinct|exists:raws,id',
            'ration_raws.*.ratio' => 'required|numeric|min:0',
        ];
    }
}
