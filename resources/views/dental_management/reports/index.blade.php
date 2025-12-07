@extends('layouts.app')

@section('title', __('dental_management.reports.title'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">{{ __('dental_management.reports.title') }}</h1>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($stats['total_patients']) }}</h3>
                            <p>{{ __('dental_management.reports.total_patients') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($stats['total_appointments']) }}</h3>
                            <p>{{ __('dental_management.reports.total_appointments') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>S/ {{ number_format($stats['total_revenue'], 2) }}</h3>
                            <p>{{ __('dental_management.reports.total_revenue') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($stats['appointments_today']) }}</h3>
                            <p>{{ __('dental_management.reports.appointments_today') }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Links -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('dental_management.reports.appointments_report') }}</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ __('dental_management.reports.appointments_report_desc') }}</p>
                            <a href="{{ route('dental_management.reports.appointments') }}" class="btn btn-primary">
                                <i class="fas fa-calendar"></i> {{ __('global.view') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('dental_management.reports.payments_report') }}</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ __('dental_management.reports.payments_report_desc') }}</p>
                            <a href="{{ route('dental_management.reports.payments') }}" class="btn btn-success">
                                <i class="fas fa-money-bill"></i> {{ __('global.view') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('dental_management.reports.patients_report') }}</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ __('dental_management.reports.patients_report_desc') }}</p>
                            <a href="{{ route('dental_management.reports.patients') }}" class="btn btn-info">
                                <i class="fas fa-users"></i> {{ __('global.view') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection