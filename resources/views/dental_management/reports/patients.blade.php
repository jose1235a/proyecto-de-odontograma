@extends('layouts.app')

@section('title', __('dental_management.reports.patients_report'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dental_management.reports.patients_report') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('dental_management.reports.export_patients') }}"
                           class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> {{ __('global.export_excel') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.reports.total_patients') }}</span>
                                    <span class="info-box-number">{{ $stats['total_patients'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-user-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.reports.active_patients') }}</span>
                                    <span class="info-box-number">{{ $stats['active_patients'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-calendar-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.reports.patients_with_appointments') }}</span>
                                    <span class="info-box-number">{{ $stats['patients_with_appointments'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.reports.patients_with_payments') }}</span>
                                    <span class="info-box-number">{{ $stats['patients_with_payments'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Patients Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('dental_management.patients.name') }}</th>
                                    <th>{{ __('dental_management.patients.email') }}</th>
                                    <th>{{ __('dental_management.patients.phone') }}</th>
                                    <th>{{ __('dental_management.patients.status') }}</th>
                                    <th>{{ __('dental_management.reports.total_appointments') }}</th>
                                    <th>{{ __('dental_management.reports.total_payments') }}</th>
                                    <th>{{ __('dental_management.patients.created_at') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($patients as $patient)
                                    <tr>
                                        <td>{{ $patient->name }}</td>
                                        <td>{{ $patient->email }}</td>
                                        <td>{{ $patient->phone ?? '-' }}</td>
                                        <td>{!! $patient->state_html !!}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $patient->appointments_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">{{ $patient->payments_count }}</span>
                                        </td>
                                        <td>{{ $patient->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('global.no_records') }}</td>
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