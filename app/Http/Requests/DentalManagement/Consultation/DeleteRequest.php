<?php

namespace App\Http\Requests\DentalManagement\Consultation;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'reason' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => __('dental_management.consultations.validation.reason_required'),
            'reason.max' => __('dental_management.consultations.validation.reason_max'),
        ];
    }

    public function attributes(): array
    {
        return [
            'reason' => __('dental_management.consultations.fields.reason'),
        ];
    }
}