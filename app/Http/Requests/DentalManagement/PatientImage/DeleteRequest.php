<?php

namespace App\Http\Requests\DentalManagement\PatientImage;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'reason' => 'required|string|min:10|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'reason.required' => __('dental_management.patient_images.validation.delete_reason_required'),
            'reason.min' => __('dental_management.patient_images.validation.delete_reason_min'),
            'reason.max' => __('dental_management.patient_images.validation.delete_reason_max'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'reason' => __('dental_management.patient_images.fields.delete_reason'),
        ];
    }
}
