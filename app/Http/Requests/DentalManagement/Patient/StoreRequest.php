<?php

namespace App\Http\Requests\DentalManagement\Patient;

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
            'document_type' => 'required|string|in:dni,passport,other',
            'document' => 'required|string|max:20|unique:patients,document',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'email' => 'nullable|email|unique:patients,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date|before:today',
            'observations' => 'nullable|string|max:1000',
            'under_medical_treatment' => 'nullable|in:0,1',
            'prone_to_bleeding' => 'nullable|in:0,1',
            'allergic_to_medication' => 'nullable|in:0,1',
            'hypertensive' => 'nullable|in:0,1',
            'diabetic' => 'nullable|in:0,1',
            'pregnant' => 'nullable|in:0,1',
            'referred_by' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'under_medical_treatment_description' => 'nullable|string|max:1000',
            'prone_to_bleeding_description' => 'nullable|string|max:1000',
            'allergic_to_medication_description' => 'nullable|string|max:1000',
            'hypertensive_description' => 'nullable|string|max:1000',
            'diabetic_description' => 'nullable|string|max:1000',
            'pregnant_description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            // First consultation fields
            'consultation_date' => 'required|date|after_or_equal:today',
            'consultation_time' => 'required|date_format:H:i',
            'treatment_id' => 'required|exists:treatments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'fever' => 'nullable|numeric|min:30|max:45',
            'blood_pressure' => 'nullable|string|max:20|regex:/^\d{2,3}\/\d{2,3}$/',
            'consultation_cost' => 'required|numeric|min:0|max:999999.99',
            'consultation_description' => 'required|string|max:1000',
            'consultation_reason' => 'nullable|string|max:1000',
            'diagnosis' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'document_type.required' => __('dental_management.patients.validation.document_type_required'),
            'document_type.in' => __('dental_management.patients.validation.document_type_invalid'),
            'document.required' => __('dental_management.patients.validation.document_required'),
            'document.unique' => __('dental_management.patients.validation.document_unique'),
            'name.required' => __('dental_management.patients.validation.name_required'),
            'last_name.required' => __('dental_management.patients.validation.last_name_required'),
            'gender.required' => __('dental_management.patients.validation.gender_required'),
            'email.email' => __('dental_management.patients.validation.email_invalid'),
            'email.unique' => __('dental_management.patients.validation.email_unique'),
            'birth_date.date' => __('dental_management.patients.validation.birth_date_invalid'),
            'birth_date.before' => __('dental_management.patients.validation.birth_date_before'),
            'consultation_date.date' => __('dental_management.patients.validation.consultation_date_invalid'),
            'consultation_date.after_or_equal' => __('dental_management.patients.validation.consultation_date_future'),
            'consultation_time.date_format' => __('dental_management.patients.validation.consultation_time_invalid'),
            'consultation_time_required' => __('dental_management.patients.validation.consultation_time_required'),
            'consultation_description_required' => __('dental_management.patients.validation.consultation_description_required'),
            'treatment_id.required' => __('dental_management.patients.validation.treatment_required'),
            'treatment_id.exists' => __('dental_management.patients.validation.treatment_exists'),
            'doctor_id.required' => __('dental_management.patients.validation.doctor_required'),
            'doctor_id.exists' => __('dental_management.patients.validation.doctor_exists'),
            'fever.numeric' => __('dental_management.patients.validation.fever_numeric'),
            'fever.min' => __('dental_management.patients.validation.fever_min'),
            'fever.max' => __('dental_management.patients.validation.fever_max'),
            'blood_pressure.regex' => __('dental_management.patients.validation.blood_pressure_format'),
            'blood_pressure.max' => __('dental_management.patients.validation.blood_pressure_max'),
            'consultation_cost.required' => __('dental_management.patients.validation.consultation_cost_required'),
            'consultation_cost.numeric' => __('dental_management.patients.validation.consultation_cost_numeric'),
            'consultation_cost.min' => __('dental_management.patients.validation.consultation_cost_min'),
            'consultation_cost.max' => __('dental_management.patients.validation.consultation_cost_max'),
            'consultation_description.max' => __('dental_management.patients.validation.consultation_description_max'),
        ];
    }

    public function attributes(): array
    {
        return [
            'document_type' => __('dental_management.patients.fields.document_type'),
            'document' => __('dental_management.patients.fields.document'),
            'name' => __('dental_management.patients.fields.name'),
            'last_name' => __('dental_management.patients.fields.last_name'),
            'gender' => __('dental_management.patients.fields.gender'),
            'email' => __('dental_management.patients.fields.email'),
            'phone' => __('dental_management.patients.fields.phone'),
            'address' => __('dental_management.patients.fields.address'),
            'birth_date' => __('dental_management.patients.fields.birth_date'),
            'observations' => __('dental_management.patients.fields.observations'),
            'emergency_contact' => __('dental_management.patients.fields.emergency_contact'),
            'consultation_date' => __('dental_management.patients.consultation_date'),
            'consultation_time' => __('dental_management.patients.consultation_time'),
            'treatment_id' => __('dental_management.consultations.treatment_id'),
            'doctor_id' => __('dental_management.consultations.doctor_id'),
            'fever' => __('dental_management.patients.fever'),
            'blood_pressure' => __('dental_management.patients.blood_pressure'),
            'consultation_cost' => __('dental_management.patients.consultation_cost'),
            'consultation_description' => __('dental_management.patients.consultation_description'),
        ];
    }
}
