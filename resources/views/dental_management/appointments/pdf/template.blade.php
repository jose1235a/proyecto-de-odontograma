<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('dental_management.appointments.plural') }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h1>{{ __('dental_management.appointments.plural') }}</h1>
    <p>{{ __('global.generated_at') }}: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>{{ __('global.id') }}</th>
                <th>{{ __('dental_management.appointments.treatment') }}</th>
                <th>{{ __('dental_management.appointments.doctor') }}</th>
                <th>{{ __('dental_management.appointments.patient') }}</th>
                <th>{{ __('dental_management.appointments.date') }}</th>
                <th>{{ __('dental_management.appointments.time') }}</th>
                <th>{{ __('dental_management.appointments.disease') }}</th>
                <th>{{ __('dental_management.appointments.status') }}</th>
                <th>{{ __('dental_management.appointments.cost') }}</th>
                <th>{{ __('dental_management.appointments.paid') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $index => $appointment)
                @php
                    $doctorName = $appointment->doctor ? trim($appointment->doctor->name . ' ' . ($appointment->doctor->last_name ?? '')) : '-';
                    $patientName = $appointment->patient ? trim($appointment->patient->name . ' ' . ($appointment->patient->last_name ?? '')) : '-';
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $appointment->treatment->name ?? '-' }}</td>
                    <td>{{ $doctorName }}</td>
                    <td>{{ $patientName }}</td>
                    <td>{{ $appointment->appointment_date ? $appointment->appointment_date->format('d/m/Y') : '-' }}</td>
                    <td>{{ $appointment->appointment_time ? $appointment->appointment_time->format('H:i') : '-' }}</td>
                    <td>{{ $appointment->disease ?? '-' }}</td>
                    <td>{{ $appointment->status_text }}</td>
                    <td>{{ number_format($appointment->cost ?? 0, 2) }}</td>
                    <td>{{ number_format($appointment->paid ?? 0, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align:center;">{{ __('global.no_records') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
