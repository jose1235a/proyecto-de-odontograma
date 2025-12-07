<?php

namespace App\Http\Requests\DentalManagement\Appointment;

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
            'reason' => 'required|string|min:10|max:500',
        ];
    }

    public function attributes(): array
    {
        return [
            'reason' => __('global.delete_description'),
        ];
    }
}
