@extends('layouts.app')

@section('title', __('dental_management.payments.create_title'))
@section('title_navbar', __('dental_management.payments.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-success rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-plus"></i> {{ __('dental_management.payments.create_title') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('dental_management.payments.partials.form_create')
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-success mr-4">
          <i class="fas fa-save"></i> {{ __('global.save') }}
        </button>
        @if(request()->has('patient_id'))
          @php
            $patientId = request()->patient_id;
            $patient = \App\Models\Patient::where('slug', $patientId)->first() ?? \App\Models\Patient::find($patientId);
            $redirectSlug = $patient ? $patient->slug : null;
          @endphp
          @if($redirectSlug)
            <a href="{{ route('dental_management.patients.show', $redirectSlug) }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
            </a>
          @else
            <a href="{{ route('dental_management.payments.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
            </a>
          @endif
        @else
          <a href="{{ route('dental_management.payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
          </a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@include('dental_management.payments.partials.scripts')
@endpush