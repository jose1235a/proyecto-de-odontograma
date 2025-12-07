<?php

namespace App\Http\Requests\DentalManagement\Odontogram;

use App\Rules\DentalManagement\ValidOdontogramData;
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
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'description' => 'required|string|max:1000',
            'odontogram_data' => ['required', 'json', new ValidOdontogramData()],
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => __('dental_management.odontogram.validation.patient_required'),
            'patient_id.exists' => __('dental_management.odontogram.validation.patient_exists'),
            'doctor_id.required' => __('dental_management.odontogram.validation.doctor_required'),
            'doctor_id.exists' => __('dental_management.odontogram.validation.doctor_exists'),
            'description.required' => __('dental_management.odontogram.validation.description_required'),
            'description.max' => __('dental_management.odontogram.validation.description_max'),
            'odontogram_data.required' => __('dental_management.odontogram.validation.odontogram_data_required'),
            'odontogram_data.json' => __('dental_management.odontogram.validation.odontogram_data_invalid'),
        ];
    }

    public function attributes(): array
    {
        return [
            'patient_id' => __('dental_management.odontogram.patient'),
            'doctor_id' => __('dental_management.odontogram.doctor'),
            'description' => __('dental_management.odontogram.description'),
            'odontogram_data' => __('dental_management.odontogram.odontogram_data'),
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
