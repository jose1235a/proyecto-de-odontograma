@extends('layouts.app')

@section('title', __('dental_management.payments.edit_title'))
@section('title_navbar', __('dental_management.payments.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-warning rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-edit"></i> {{ __('dental_management.payments.edit_title') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('dental_management.payments.partials.form_edit')
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-warning mr-4">
          <i class="fas fa-save"></i> {{ __('global.update') }}
        </button>
        <a href="{{ $backUrl }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@include('dental_management.payments.partials.scripts')
@endpush