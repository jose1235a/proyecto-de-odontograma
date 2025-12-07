<?php

namespace App\Http\Requests\DentalManagement\Doctor;

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
        $doctorId = $this->route('doctor')->id ?? $this->route('doctor');

        return [
            'document_type' => 'required|string|in:dni,passport,other',
            'document' => [
                'required',
                'string',
                'max:20',
                Rule::unique('doctors', 'document')->ignore($doctorId)
            ],
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('doctors', 'email')->ignore($doctorId)
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'specialties' => 'required|array|min:1',
            'specialties.*' => 'required|integer|exists:specialties,id',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'document_type.required' => __('dental_management.doctors.validation.document_type_required'),
            'document_type.in' => __('dental_management.doctors.validation.document_type_invalid'),
            'document.required' => __('dental_management.doctors.validation.document_required'),
            'document.unique' => __('dental_management.doctors.validation.document_unique'),
            'name.required' => __('dental_management.doctors.validation.name_required'),
            'last_name.required' => __('dental_management.doctors.validation.last_name_required'),
            'email.required' => __('dental_management.doctors.validation.email_required'),
            'email.email' => __('dental_management.doctors.validation.email_invalid'),
            'email.unique' => __('dental_management.doctors.validation.email_unique'),
            'specialties.required' => __('dental_management.doctors.validation.specialty_required'),
            'specialties.array' => __('dental_management.doctors.validation.specialties_array'),
            'specialties.min' => __('dental_management.doctors.validation.specialties_min'),
            'specialties.*.exists' => __('dental_management.doctors.validation.specialty_exists'),
        ];
    }

    public function attributes(): array
    {
        return [
            'document_type' => __('dental_management.doctors.fields.document_type'),
            'document' => __('dental_management.doctors.fields.document'),
            'name' => __('dental_management.doctors.fields.name'),
            'last_name' => __('dental_management.doctors.fields.last_name'),
            'email' => __('dental_management.doctors.fields.email'),
            'phone' => __('dental_management.doctors.fields.phone'),
            'address' => __('dental_management.doctors.fields.address'),
            'specialties' => __('dental_management.doctors.fields.specialty'),
        ];
    }
}
