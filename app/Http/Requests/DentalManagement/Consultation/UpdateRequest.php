<?php

namespace App\Http\Requests\DentalManagement\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'treatment_id' => 'required|exists:treatments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'consultation_date' => 'required|date|before_or_equal:today',
            'consultation_time' => 'required|date_format:H:i',
            'description' => 'required|string|max:1000',
            'fever' => 'nullable|numeric|min:30|max:45',
            'blood_pressure' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => __('dental_management.consultations.validation.patient_required'),
            'patient_id.exists' => __('dental_management.consultations.validation.patient_exists'),
            'treatment_id.required' => __('dental_management.consultations.validation.treatment_required'),
            'treatment_id.exists' => __('dental_management.consultations.validation.treatment_exists'),
            'doctor_id.required' => __('dental_management.consultations.validation.doctor_required'),
            'doctor_id.exists' => __('dental_management.consultations.validation.doctor_exists'),
            'consultation_date.required' => __('dental_management.consultations.validation.consultation_date_required'),
            'consultation_date.date' => __('dental_management.consultations.validation.consultation_date_invalid'),
            'consultation_date.before_or_equal' => __('dental_management.consultations.validation.consultation_date_future'),
            'consultation_time.required' => __('dental_management.consultations.validation.consultation_time_required'),
            'consultation_time.date_format' => __('dental_management.consultations.validation.consultation_time_invalid'),
            'description.required' => __('dental_management.consultations.validation.description_required'),
            'description.max' => __('dental_management.consultations.validation.description_max'),
            'fever.numeric' => __('dental_management.consultations.validation.fever_numeric'),
            'fever.min' => __('dental_management.consultations.validation.fever_min'),
            'fever.max' => __('dental_management.consultations.validation.fever_max'),
            'blood_pressure.max' => __('dental_management.consultations.validation.blood_pressure_max'),
        ];
    }

    public function attributes(): array
    {
        return [
            'patient_id' => __('dental_management.consultations.fields.patient'),
            'treatment_id' => __('dental_management.consultations.fields.treatment'),
            'doctor_id' => __('dental_management.consultations.fields.doctor'),
            'consultation_date' => __('dental_management.consultations.fields.consultation_date'),
            'consultation_time' => __('dental_management.consultations.fields.consultation_time'),
            'cost' => __('dental_management.consultations.fields.cost'),
            'description' => __('dental_management.consultations.fields.description'),
            'fever' => __('dental_management.consultations.fields.fever'),
            'blood_pressure' => __('dental_management.consultations.fields.blood_pressure'),
            'is_active' => __('dental_management.consultations.fields.is_active'),
        ];
    }
}