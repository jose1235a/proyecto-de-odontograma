<?php

namespace App\Http\Requests\DentalManagement\Payment;

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
            'appointment_id' => 'nullable|exists:appointments,id',
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'payment_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|in:cash,card,transfer,check',
            'status' => 'required|in:pending,completed,cancelled,refunded',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_id.exists' => __('dental_management.payments.validation.appointment_exists'),
            'patient_id.required' => __('dental_management.payments.validation.patient_required'),
            'patient_id.exists' => __('dental_management.payments.validation.patient_exists'),
            'amount.required' => __('dental_management.payments.validation.amount_required'),
            'amount.numeric' => __('dental_management.payments.validation.amount_numeric'),
            'amount.min' => __('dental_management.payments.validation.amount_min'),
            'amount.max' => __('dental_management.payments.validation.amount_max'),
            'payment_date.required' => __('dental_management.payments.validation.payment_date_required'),
            'payment_date.date' => __('dental_management.payments.validation.payment_date_invalid'),
            'payment_date.before_or_equal' => __('dental_management.payments.validation.payment_date_future'),
            'payment_method.required' => __('dental_management.payments.validation.payment_method_required'),
            'payment_method.in' => __('dental_management.payments.validation.payment_method_invalid'),
            'status.required' => __('dental_management.payments.validation.status_required'),
            'status.in' => __('dental_management.payments.validation.status_invalid'),
            'reference_number.max' => __('dental_management.payments.validation.reference_max'),
            'notes.max' => __('dental_management.payments.validation.notes_max'),
        ];
    }

    public function attributes(): array
    {
        return [
            'appointment_id' => __('dental_management.payments.fields.appointment'),
            'patient_id' => __('dental_management.payments.fields.patient'),
            'amount' => __('dental_management.payments.fields.amount'),
            'payment_date' => __('dental_management.payments.fields.payment_date'),
            'payment_method' => __('dental_management.payments.fields.payment_method'),
            'status' => __('dental_management.payments.fields.status'),
            'reference_number' => __('dental_management.payments.fields.reference_number'),
            'notes' => __('dental_management.payments.fields.notes'),
        ];
    }
}
