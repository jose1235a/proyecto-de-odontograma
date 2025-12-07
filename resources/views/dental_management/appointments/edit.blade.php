@extends('layouts.app')

@section('title', __('dental_management.appointments.edit_title'))
@section('title_navbar', __('dental_management.appointments.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-edit"></i> {{ __('global.edit') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('dental_management.appointments.partials.form_fields', [
            'formAction' => route('dental_management.appointments.update', $appointment),
            'method' => 'PUT',
            'appointment' => $appointment,
            'returnUrl' => request('return_url'),
        ])
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="appointment-form" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> {{ __('global.update') }}
        </button>
        <a href="{{ request('return_url', route('dental_management.appointments.index')) }}" class="btn btn-default">
          <i class="fas fa-times"></i> {{ __('global.cancel') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@include('dental_management.appointments.partials.form_scripts', [
    'searchPatientUrl' => route('dental_management.appointments.search_patient'),
])
@endpush
