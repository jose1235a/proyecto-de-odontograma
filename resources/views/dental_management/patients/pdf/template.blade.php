<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('dental_management.patients.plural') }}</title>
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
        .page-break {
            page-break-before: always;
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
        <h1>{{ __('dental_management.patients.plural') }}</h1>
        <p>{{ __('global.generated_at') }}: {{ now()->format('d/m/Y H:i:s') }}</p>
        @if(isset($filters) && !empty(array_filter($filters)))
            <p>{{ __('global.filters_applied') }}: {{ implode(', ', array_filter($filters)) }}</p>
        @endif
    </div>

    @if($patients->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>{{ __('dental_management.patients.id') }}</th>
                    <th>{{ __('dental_management.patients.name') }}</th>
                    <th>{{ __('dental_management.patients.last_name') }}</th>
                    <th>{{ __('dental_management.patients.email') }}</th>
                    <th>{{ __('dental_management.patients.phone') }}</th>
                    <th>{{ __('dental_management.patients.document') }}</th>
                    <th>{{ __('dental_management.patients.is_active') }}</th>
                    <th>{{ __('global.created_at') }}</th>
                    <th>{{ __('global.created_by') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $index => $patient)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->last_name ?? '-' }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->phone ?? '-' }}</td>
                        <td>{{ $patient->document ?? '-' }}</td>
                        <td>{{ $patient->state_text }}</td>
                        <td>{{ $patient->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $patient->creator->name ?? '-' }}</td>
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
        <p>{{ __('global.total_records') }}: {{ $patients->count() }}</p>
    </div>
</body>
</html>