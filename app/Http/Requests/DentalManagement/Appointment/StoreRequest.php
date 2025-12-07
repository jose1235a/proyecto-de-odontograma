<?php

namespace App\Http\Requests\DentalManagement\Appointment;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Appointment;
use Carbon\Carbon;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'treatment_id' => 'required|exists:treatments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'disease' => 'nullable|string|max:255',
            'status' => 'nullable|in:scheduled,completed,cancelled',
            'cost' => 'nullable|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => __('dental_management.appointments.validation.patient_required'),
            'patient_id.exists' => __('dental_management.appointments.validation.patient_exists'),
            'doctor_id.required' => __('dental_management.appointments.validation.doctor_required'),
            'doctor_id.exists' => __('dental_management.appointments.validation.doctor_exists'),
            'treatment_id.required' => __('dental_management.appointments.validation.treatment_required'),
            'treatment_id.exists' => __('dental_management.appointments.validation.treatment_exists'),
            'appointment_date.required' => __('dental_management.appointments.validation.date_required'),
            'appointment_date.after_or_equal' => __('dental_management.appointments.validation.date_not_past'),
            'appointment_time.required' => __('dental_management.appointments.validation.time_required'),
            'appointment_time.date_format' => __('dental_management.appointments.validation.time_format'),
            'disease.string' => __('dental_management.appointments.validation.disease_string'),
            'cost.numeric' => __('dental_management.appointments.validation.cost_numeric'),
            'paid.numeric' => __('dental_management.appointments.validation.paid_numeric'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $patientId = $this->input('patient_id');
            $date = $this->input('appointment_date');
            $time = $this->input('appointment_time');

            if (!$patientId || !$date || !$time) {
                return;
            }

            $target = Carbon::parse("{$date} {$time}");
            $from = $target->copy()->subMinutes(15);
            $to = $target->copy()->addMinutes(15);

            $existsOverlap = Appointment::where('patient_id', $patientId)
                ->where('status', 'scheduled')
                ->whereRaw("CONCAT(appointment_date, ' ', appointment_time) BETWEEN ? AND ?", [
                    $from->format('Y-m-d H:i:s'),
                    $to->format('Y-m-d H:i:s'),
                ])
                ->exists();

            if ($existsOverlap) {
                $validator->errors()->add('appointment_time', __('dental_management.appointments.validation.overlap'));
            }
        });
    }

    public function attributes(): array
    {
        return [
            'patient_id' => __('dental_management.appointments.fields.patient'),
            'doctor_id' => __('dental_management.appointments.fields.doctor'),
            'treatment_id' => __('dental_management.appointments.fields.treatment'),
            'appointment_date' => __('dental_management.appointments.fields.date'),
            'appointment_time' => __('dental_management.appointments.fields.time'),
            'disease' => __('dental_management.appointments.fields.disease'),
            'status' => __('dental_management.appointments.fields.status'),
            'cost' => __('dental_management.appointments.fields.cost'),
            'paid' => __('dental_management.appointments.fields.paid'),
        ];
    }
}
