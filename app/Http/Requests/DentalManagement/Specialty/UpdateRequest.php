<?php

namespace App\Http\Requests\DentalManagement\Specialty;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $specialtyId = $this->route('specialty')->id ?? $this->route('specialty');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('specialties', 'name')->ignore($specialtyId)
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('dental_management.specialties.validation.name_required'),
            'name.unique' => __('dental_management.specialties.validation.name_unique'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('dental_management.specialties.fields.name'),
        ];
    }
}
