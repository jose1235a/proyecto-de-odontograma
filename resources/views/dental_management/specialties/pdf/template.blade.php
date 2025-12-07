<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('dental_management.specialties.plural') }}</title>
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
        <h1>{{ __('dental_management.specialties.plural') }}</h1>
        <p>{{ __('global.generated_at') }}: {{ now()->format('d/m/Y H:i:s') }}</p>
        @if(isset($filters) && !empty(array_filter($filters)))
            <p>{{ __('global.filters_applied') }}: {{ implode(', ', array_filter($filters)) }}</p>
        @endif
    </div>

    @if($specialties->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>{{ __('dental_management.specialties.id') }}</th>
                    <th>{{ __('dental_management.specialties.name') }}</th>
                    <th>{{ __('dental_management.specialties.description') }}</th>
                    <th>{{ __('dental_management.specialties.is_active') }}</th>
                    <th>{{ __('global.created_at') }}</th>
                    <th>{{ __('global.created_by') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($specialties as $index => $specialty)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $specialty->name }}</td>
                        <td>{{ $specialty->description ?? '-' }}</td>
                        <td>{{ $specialty->state_text }}</td>
                        <td>{{ $specialty->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $specialty->creator->name ?? '-' }}</td>
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
        <p>{{ __('global.total_records') }}: {{ $specialties->count() }}</p>
    </div>
</body>
</html>
