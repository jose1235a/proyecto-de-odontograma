@extends('layouts.app')

@section('title', __('dental_management.consultations.delete_title'))
@section('title_navbar', __('dental_management.consultations.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-danger rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-trash"></i> {{ __('dental_management.consultations.delete') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('dental_management.consultations.partials.form_delete')
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-delete" class="btn btn-danger mr-4">
          <i class="fas fa-trash"></i> {{ __('global.delete') }}
        </button>
        <a href="{{ route('dental_management.consultations.index') }}" class="btn btn-default">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection