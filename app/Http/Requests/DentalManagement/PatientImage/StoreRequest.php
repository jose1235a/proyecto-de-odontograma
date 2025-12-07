<?php

namespace App\Http\Requests\DentalManagement\PatientImage;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'title' => 'required|string|max:255',
            'image' => 'required_without:photo|image|mimes:jpeg,png,jpg,gif|max:5120',
            'photo' => 'required_without:image|string',
            'description' => 'required|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'patient_id.required' => __('dental_management.patient_images.validation.patient_required'),
            'patient_id.exists' => __('dental_management.patient_images.validation.patient_exists'),
            'title.required' => __('dental_management.patient_images.validation.title_required'),
            'title.max' => __('dental_management.patient_images.validation.title_max'),
            'image.required_without' => __('dental_management.patient_images.validation.image_required'),
            'image.image' => __('dental_management.patient_images.validation.image_image'),
            'image.mimes' => __('dental_management.patient_images.validation.image_mimes'),
            'image.max' => __('dental_management.patient_images.validation.image_max'),
            'description.required' => __('dental_management.patient_images.validation.description_required'),
            'description.max' => __('dental_management.patient_images.validation.description_max'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'patient_id' => __('dental_management.patient_images.fields.patient'),
            'title' => __('dental_management.patient_images.fields.title'),
            'image' => __('dental_management.patients.upload_image'),
            'photo' => __('dental_management.patients.take_photo'),
            'description' => __('dental_management.patient_images.fields.description'),
        ];
    }
}
