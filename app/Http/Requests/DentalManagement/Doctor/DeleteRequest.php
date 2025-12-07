<?php

namespace App\Http\Requests\DentalManagement\Doctor;

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
            'reason' => 'required|string|max:500|min:10',
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => __('dental_management.doctors.validation.delete_reason_required'),
            'reason.min' => __('dental_management.doctors.validation.delete_reason_min'),
            'reason.max' => __('dental_management.doctors.validation.delete_reason_max'),
        ];
    }

    public function attributes(): array
    {
        return [
            'reason' => __('dental_management.doctors.fields.delete_reason'),
        ];
    }
}
