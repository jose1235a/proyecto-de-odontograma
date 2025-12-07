<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Pagos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #e8f4f8 !important;
            font-weight: bold;
        }
        .amount {
            text-align: right;
        }
        .status-completed {
            color: #28a745;
            font-weight: bold;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }
        .status-refunded {
            color: #6c757d;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Pagos</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Total de registros: {{ $payments->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Fecha de Pago</th>
                <th>Paciente</th>
                <th>DNI</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Estado</th>
                <th>Referencia</th>
                <th>Notas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $index => $payment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                <td>{{ $payment->patient->name }} {{ $payment->patient->last_name }}</td>
                <td>{{ $payment->patient->document }}</td>
                <td class="amount">S/ {{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->payment_method }}</td>
                <td>
                    <span class="status-{{ $payment->status }}">
                        {{ $payment->status }}
                    </span>
                </td>
                <td>{{ $payment->reference_number ?? '-' }}</td>
                <td>{{ $payment->notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL:</td>
                <td class="amount">S/ {{ number_format($payments->sum('amount'), 2) }}</td>
                <td colspan="4"></td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px; text-align: center; font-size: 10px; color: #666;">
        <p>Reporte generado por el Sistema de Gestión Dental</p>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>