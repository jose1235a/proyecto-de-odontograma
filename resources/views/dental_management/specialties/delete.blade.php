@extends('layouts.app')

@section('title', __('dental_management.specialties.delete_title'))
@section('title_navbar', __('dental_management.specialties.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-danger rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-trash"></i> {{ __('dental_management.specialties.delete_title') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="alert alert-warning">
          <h5><i class="icon fas fa-exclamation-triangle"></i> {{ __('global.warning') }}!</h5>
          {{ __('global.delete_confirmation_message') }}
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('dental_management.specialties.name') }}</label>
              <p class="form-control-plaintext">{{ $specialty->name }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('global.status') }}</label>
              <p class="form-control-plaintext">
                @if($specialty->is_active)
                  <span class="badge badge-success">{{ __('global.active') }}</span>
                @else
                  <span class="badge badge-danger">{{ __('global.inactive') }}</span>
                @endif
              </p>
            </div>
          </div>
        </div>

        <form id="form-delete" method="POST" action="{{ route('dental_management.specialties.deleteSave', $specialty) }}" data-parsley-validate>
          @csrf
          @method('DELETE')
          @include('dental_management.specialties.partials.form_delete')
        </form>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-delete" class="btn btn-danger mr-4">
          <i class="fas fa-trash"></i> {{ __('global.delete') }}
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