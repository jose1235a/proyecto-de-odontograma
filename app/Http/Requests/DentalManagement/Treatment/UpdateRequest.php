<?php

namespace App\Http\Requests\DentalManagement\Treatment;

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
        $treatmentId = $this->route('treatment')->id ?? $this->route('treatment');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('treatments', 'name')->ignore($treatmentId)
            ],
            'description' => 'nullable|string|max:1000',
            'cost' => 'required|numeric|min:0|max:999999.99',
            'color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'coverage' => 'required|string|in:partial,full',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('dental_management.treatments.validation.name_required'),
            'name.unique' => __('dental_management.treatments.validation.name_unique'),
            'cost.required' => __('dental_management.treatments.validation.cost_required'),
            'cost.numeric' => __('dental_management.treatments.validation.cost_numeric'),
            'cost.min' => __('dental_management.treatments.validation.cost_min'),
            'cost.max' => __('dental_management.treatments.validation.cost_max'),
            'coverage.required' => __('dental_management.treatments.validation.coverage_required'),
            'coverage.in' => __('dental_management.treatments.validation.coverage_invalid'),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('dental_management.treatments.fields.name'),
            'description' => __('dental_management.treatments.fields.description'),
            'cost' => __('dental_management.treatments.fields.cost'),
            'coverage' => __('dental_management.treatments.fields.coverage'),
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
