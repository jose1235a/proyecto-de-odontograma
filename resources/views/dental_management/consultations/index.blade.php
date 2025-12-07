@extends('layouts.app')

@section('title', __('dental_management.consultations.plural'))
@section('title_navbar', __('dental_management.consultations.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-stethoscope"></i> {{ __('dental_management.consultations.plural') }}
        </h3>
        <div class="card-tools">
          <a href="{{ route('dental_management.consultations.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus"></i> {{ __('global.create') }}
          </a>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('dental_management.consultations.partials.index_filters')
        @include('dental_management.consultations.partials.index_results')
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
@include('dental_management.consultations.partials.scripts')
@endsection