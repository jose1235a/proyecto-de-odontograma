@extends('layouts.app')

@section('title', __('dental_management.summary.title'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{{ __('dental_management.summary.title') }}</h1>

            <!-- General Statistics -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($summary['general']['total_patients']) }}</h3>
                            <p>{{ __('dental_management.summary.total_patients') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($summary['general']['total_appointments']) }}</h3>
                            <p>{{ __('dental_management.summary.total_appointments') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>S/ {{ number_format($summary['financial']['total_revenue'], 2) }}</h3>
                            <p>{{ __('dental_management.summary.total_revenue') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($summary['general']['today_appointments']) }}</h3>
                            <p>{{ __('dental_management.summary.today_appointments') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Trends Chart -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('dental_management.summary.monthly_trends') }}</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyTrendsChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('dental_management.summary.top_doctors') }}</h3>
                        </div>
                        <div class="card-body">
                            @forelse($summary['top_doctors'] as $doctor)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $doctor['doctor'] }}</span>
                                    <span class="badge badge-primary">{{ $doctor['appointments'] }}</span>
                                </div>
                            @empty
                                <p class="text-muted">{{ __('global.no_records') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('dental_management.summary.top_treatments') }}</h3>
                        </div>
                        <div class="card-body">
                            @forelse($summary['top_treatments'] as $treatment)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $treatment['treatment'] }}</span>
                                    <span class="badge badge-success">{{ $treatment['appointments'] }}</span>
                                </div>
                            @empty
                                <p class="text-muted">{{ __('global.no_records') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('dental_management.summary.recent_appointments') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>{{ __('dental_management.appointments.patient') }}</th>
                                            <th>{{ __('dental_management.appointments.date') }}</th>
                                            <th>{{ __('dental_management.appointments.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($summary['recent_appointments'] as $appointment)
                                            <tr>
                                                <td>{{ $appointment['patient'] }}</td>
                                                <td>{{ $appointment['date'] }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $appointment['status'] == 'completed' ? 'success' : 'warning' }}">
                                                        {{ $appointment['status'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">{{ __('global.no_records') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('dental_management.summary.recent_payments') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>{{ __('dental_management.payments.patient') }}</th>
                                            <th>{{ __('dental_management.payments.amount') }}</th>
                                            <th>{{ __('dental_management.payments.date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($summary['recent_payments'] as $payment)
                                            <tr>
                                                <td>{{ $payment['patient'] }}</td>
                                                <td>S/ {{ number_format($payment['amount'], 2) }}</td>
                                                <td>{{ $payment['date'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">{{ __('global.no_records') }}</td>
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
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@include('dental_management.summary.partials.scripts')
@endpush