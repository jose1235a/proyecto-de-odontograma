@extends('layouts.app')

@section('title', __('dental_management.reports.payments_report'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dental_management.reports.payments_report') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('dental_management.reports.export_payments', request()->query()) }}"
                           class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> {{ __('global.export_excel') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>{{ __('global.start_date') }}</label>
                                <input type="date" name="start_date" class="form-control"
                                       value="{{ $startDate }}">
                            </div>
                            <div class="col-md-4">
                                <label>{{ __('global.end_date') }}</label>
                                <input type="date" name="end_date" class="form-control"
                                       value="{{ $endDate }}">
                            </div>
                            <div class="col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> {{ __('global.search') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.reports.total_amount') }}</span>
                                    <span class="info-box-number">S/ {{ number_format($stats['total_amount'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-receipt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.reports.total_payments') }}</span>
                                    <span class="info-box-number">{{ $stats['total_payments'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.payments.status_values.pending') }}</span>
                                    <span class="info-box-number">S/ {{ number_format($stats['pending'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.payments.status_values.completed') }}</span>
                                    <span class="info-box-number">S/ {{ number_format($stats['completed'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods Chart -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('dental_management.reports.payments_by_method') }}</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="paymentMethodsChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('dental_management.reports.payment_methods_summary') }}</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach($stats['by_method'] as $method => $amount)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {!! \App\Models\DentalManagement\Payment::where('payment_method', $method)->first()?->payment_method_html !!}
                                                <span class="badge badge-primary badge-pill">S/ {{ number_format($amount, 2) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payments Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('dental_management.payments.payment_date') }}</th>
                                    <th>{{ __('dental_management.payments.patient') }}</th>
                                    <th>{{ __('dental_management.payments.amount') }}</th>
                                    <th>{{ __('dental_management.payments.payment_method') }}</th>
                                    <th>{{ __('dental_management.payments.status') }}</th>
                                    <th>{{ __('dental_management.payments.reference_number') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                        <td>{{ $payment->patient->name ?? '-' }}</td>
                                        <td><strong>{{ $payment->amount_formatted }}</strong></td>
                                        <td>{!! $payment->payment_method_html !!}</td>
                                        <td>{!! $payment->status_html !!}</td>
                                        <td>{{ $payment->reference_number ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('global.no_records') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@include('dental_management.reports.partials.scripts')
@endpush