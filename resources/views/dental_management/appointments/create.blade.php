@extends('layouts.app')

@section('title', __('dental_management.appointments.create_title'))
@section('title_navbar', __('dental_management.appointments.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-plus"></i> {{ __('global.create') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('dental_management.appointments.partials.form_fields', [
            'formAction' => route('dental_management.appointments.store'),
            'method' => 'POST',
            'appointment' => null,
        ])
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="appointment-form" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> {{ __('global.save') }}
        </button>
        @if(request()->has('patient_id'))
          @php
            $patientId = request()->patient_id;
            $patient = \App\Models\Patient::where('slug', $patientId)->first() ?? \App\Models\Patient::find($patientId);
            $redirectSlug = $patient ? $patient->slug : null;
          @endphp
          @if($redirectSlug)
            <a href="{{ route('dental_management.patients.show', $redirectSlug) }}" class="btn btn-default">
              <i class="fas fa-times"></i> {{ __('global.cancel') }}
            </a>
          @else
            <a href="{{ route('dental_management.appointments.index') }}" class="btn btn-default">
              <i class="fas fa-times"></i> {{ __('global.cancel') }}
            </a>
          @endif
        @else
          <a href="{{ route('dental_management.appointments.index') }}" class="btn btn-default">
            <i class="fas fa-times"></i> {{ __('global.cancel') }}
          </a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
/* Ensure Select2 dropdown opens downward */
.select2-container--bootstrap4 .select2-dropdown {
    border-color: #ced4da;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.select2-container--bootstrap4 .select2-results__option--highlighted {
    background-color: #007bff;
    color: white;
}

.select2-container--bootstrap4 .select2-selection__clear {
    color: #6c757d;
    cursor: pointer;
    float: right;
    font-weight: bold;
    margin-right: 30px;
}
</style>
@endpush

@push('scripts')
@include('dental_management.appointments.partials.form_scripts')
@endpush
