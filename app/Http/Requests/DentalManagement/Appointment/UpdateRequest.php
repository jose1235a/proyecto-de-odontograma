<?php

namespace App\Http\Requests\DentalManagement\Appointment;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Appointment;
use Carbon\Carbon;

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
            'doctor_id' => 'required|exists:doctors,id',
            'treatment_id' => 'required|exists:treatments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'disease' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled',
            'cost' => 'nullable|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return (new StoreRequest())->messages();
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
                ->where('id', '!=', $this->route('appointment')?->id)
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
        return (new StoreRequest())->attributes();
    }
}
