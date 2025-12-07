<?php

namespace App\Http\Requests\DentalManagement\Patient;

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
        $patientId = $this->route('patient')->id ?? $this->route('patient');

        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|in:M,F',
            'email' => [
                'required',
                'email',
                Rule::unique('patients', 'email')->ignore($patientId)
            ],
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date|before:today',
            'observations' => 'nullable|string|max:1000',
            'under_medical_treatment' => 'nullable|in:0,1',
            'prone_to_bleeding' => 'nullable|in:0,1',
            'allergic_to_medication' => 'nullable|in:0,1',
            'hypertensive' => 'nullable|in:0,1',
            'diabetic' => 'nullable|in:0,1',
            'pregnant' => 'nullable|in:0,1',
            'emergency_contact' => 'nullable|string|max:255',
            'under_medical_treatment_description' => 'nullable|string|max:1000',
            'prone_to_bleeding_description' => 'nullable|string|max:1000',
            'allergic_to_medication_description' => 'nullable|string|max:1000',
            'hypertensive_description' => 'nullable|string|max:1000',
            'diabetic_description' => 'nullable|string|max:1000',
            'pregnant_description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('dental_management.patients.validation.name_required'),
            'last_name.required' => __('dental_management.patients.validation.last_name_required'),
            'email.required' => __('dental_management.patients.validation.email_required'),
            'email.email' => __('dental_management.patients.validation.email_invalid'),
            'email.unique' => __('dental_management.patients.validation.email_unique'),
            'birth_date.date' => __('dental_management.patients.validation.birth_date_invalid'),
            'birth_date.before' => __('dental_management.patients.validation.birth_date_before'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('dental_management.patients.fields.name'),
            'last_name' => __('dental_management.patients.fields.last_name'),
            'gender' => __('dental_management.patients.fields.gender'),
            'email' => __('dental_management.patients.fields.email'),
            'phone' => __('dental_management.patients.fields.phone'),
            'address' => __('dental_management.patients.fields.address'),
            'birth_date' => __('dental_management.patients.fields.birth_date'),
            'observations' => __('dental_management.patients.fields.observations'),
            'emergency_contact' => __('dental_management.patients.fields.emergency_contact'),
        ];
    }
}
