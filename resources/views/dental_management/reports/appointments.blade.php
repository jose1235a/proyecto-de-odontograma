@extends('layouts.app')

@section('title', __('dental_management.reports.appointments_report'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('dental_management.reports.appointments_report') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('dental_management.reports.export_appointments', request()->query()) }}"
                           class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> {{ __('global.export_excel') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{ __('global.start_date') }}</label>
                                <input type="date" name="start_date" class="form-control"
                                       value="{{ $startDate }}">
                            </div>
                            <div class="col-md-3">
                                <label>{{ __('global.end_date') }}</label>
                                <input type="date" name="end_date" class="form-control"
                                       value="{{ $endDate }}">
                            </div>
                            <div class="col-md-3">
                                <label>{{ __('dental_management.appointments.fields.status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="">{{ __('global.all') }}</option>
                                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>
                                        {{ __('dental_management.appointments.status.scheduled') }}
                                    </option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                                        {{ __('dental_management.appointments.status.confirmed') }}
                                    </option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        {{ __('dental_management.appointments.status.completed') }}
                                    </option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        {{ __('dental_management.appointments.status_cancelled') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
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
                                <span class="info-box-icon bg-info"><i class="fas fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.reports.total_appointments') }}</span>
                                    <span class="info-box-number">{{ $stats['total'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.appointments.status.scheduled') }}</span>
                                    <span class="info-box-number">{{ $stats['scheduled'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('dental_management.appointments.status.completed') }}</span>
                                    <span class="info-box-number">{{ $stats['completed'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                                <div class="info-box-content">
                                     <span class="info-box-text">{{ __('dental_management.appointments.status_cancelled') }}</span>
                                     <span class="info-box-number">{{ $stats['cancelled'] }}</span>
                                 </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointments Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('dental_management.appointments.fields.appointment_date') }}</th>
                                    <th>{{ __('dental_management.appointments.fields.patient') }}</th>
                                    <th>{{ __('dental_management.appointments.fields.doctor') }}</th>
                                    <th>{{ __('dental_management.appointments.fields.treatment') }}</th>
                                    <th>{{ __('dental_management.appointments.fields.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_date->format('d/m/Y H:i') }}</td>
                                        <td>{{ $appointment->patient->name ?? '-' }}</td>
                                        <td>{{ $appointment->doctor->name ?? '-' }}</td>
                                        <td>{{ $appointment->treatment->name ?? '-' }}</td>
                                        <td>{!! $appointment->status_html !!}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('global.no_records') }}</td>
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