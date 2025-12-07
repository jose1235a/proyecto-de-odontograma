@extends('layouts.app')

@section('title', __('dental_management.specialties.create_title'))
@section('title_navbar', __('dental_management.specialties.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-plus"></i> {{ __('dental_management.specialties.create_title') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <form id="form-save" method="POST" action="{{ route('dental_management.specialties.store') }}" data-parsley-validate>
          @csrf
          @include('dental_management.specialties.partials.form_create')
        </form>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> {{ __('global.save') }}
        </button>
        <a href="{{ route('dental_management.specialties.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('adminlte/js/dental_specialties.js') }}"></script>
@endpush