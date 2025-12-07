<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('dental_management.doctors.plural') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 10px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __('dental_management.doctors.plural') }}</h1>
        <p>{{ __('global.generated_at') }}: {{ now()->format('d/m/Y H:i:s') }}</p>
        @if(isset($filters) && !empty(array_filter($filters)))
            <p>{{ __('global.filters_applied') }}: {{ implode(', ', array_filter($filters)) }}</p>
        @endif
    </div>

    @if($doctors->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>{{ __('dental_management.doctors.id') }}</th>
                    <th>{{ __('dental_management.doctors.name') }}</th>
                    <th>{{ __('dental_management.doctors.last_name') }}</th>
                    <th>{{ __('dental_management.doctors.document_type') }}</th>
                    <th>{{ __('dental_management.doctors.document') }}</th>
                    <th>{{ __('dental_management.doctors.specialty') }}</th>
                    <th>{{ __('dental_management.doctors.email') }}</th>
                    <th>{{ __('dental_management.doctors.phone') }}</th>
                    <th>{{ __('dental_management.doctors.is_active') }}</th>
                    <th>{{ __('global.created_at') }}</th>
                    <th>{{ __('global.created_by') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctors as $index => $doctor)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $doctor->name }}</td>
                        <td>{{ $doctor->last_name ?? '-' }}</td>
                        <td>{{ strtoupper($doctor->document_type ?? '-') }}</td>
                        <td>{{ $doctor->document ?? '-' }}</td>
                        <td>{{ $doctor->specialty->name ?? '-' }}</td>
                        <td>{{ $doctor->email }}</td>
                        <td>{{ $doctor->phone ?? '-' }}</td>
                        <td>{{ $doctor->state_text }}</td>
                        <td>{{ optional($doctor->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $doctor->creator->name ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            {{ __('global.no_records') }}
        </div>
    @endif

    <div class="footer">
        <p>{{ __('global.generated_by') }}: {{ auth()->user()->name ?? 'System' }}</p>
        <p>{{ __('global.total_records') }}: {{ $doctors->count() }}</p>
    </div>
</body>
</html>
