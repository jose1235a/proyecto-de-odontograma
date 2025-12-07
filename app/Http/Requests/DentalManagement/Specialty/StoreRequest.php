<?php

namespace App\Http\Requests\DentalManagement\Specialty;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:specialties,name',
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
