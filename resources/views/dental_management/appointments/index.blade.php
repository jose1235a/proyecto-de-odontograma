@extends('layouts.app')

@section('title', __('dental_management.appointments.title'))
@section('title_navbar', __('dental_management.appointments.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-filter"></i> {{ __('global.card_title_filter') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <form id="appointments-filter-form" method="GET" action="{{ route('dental_management.appointments.index') }}">
          @include('dental_management.appointments.partials.index_filters')
        </form>
      </div>
      <div class="card-footer text-center">
        <button type="button" onclick="document.getElementById('appointments-filter-form').submit()" class="btn btn-primary mr-4">
          <i class="fas fa-search"></i> {{ __('global.search') }}
        </button>
        <a href="{{ route('dental_management.appointments.index') }}" class="btn btn-default">
          <i class="fas fa-brush"></i> {{ __('global.clear') }}
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title pt-1">
          <i class="fas fa-table"></i> {{ __('global.card_title_result') }}:
          {{ $appointments->total() }}
        </h3>
        <div class="card-tools">
          @can('appointments.create')
          <a class="btn btn-sm btn-primary mr-2" href="{{ route('dental_management.appointments.create') }}">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }}</span>
          </a>
          @endcan
          @can('appointments.edit_all')
          <a class="btn btn-sm bg-olive mr-2" href="{{ route('dental_management.appointments.edit_all') }}">
            <i class="fas fa-edit"></i> <span class="d-none d-sm-inline">{{ __('global.edit_all') }}</span>
          </a>
          @endcan
          @can('appointments.export')
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-file-export"></i> <span class="d-none d-sm-inline">{{ __('global.export') }}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item text-dark" href="{{ route('dental_management.appointments.export_excel', request()->query()) }}">
                <i class="fas fa-file-excel text-success"></i> {{ __('global.excel') }}
              </a>
              <a class="dropdown-item text-dark" href="{{ route('dental_management.appointments.export_pdf', request()->query()) }}">
                <i class="fas fa-file-pdf text-danger"></i> {{ __('global.pdf') }}
              </a>
              <a class="dropdown-item text-dark" href="{{ route('dental_management.appointments.export_word', request()->query()) }}">
                <i class="fas fa-file-word text-primary"></i> {{ __('global.word') }}
              </a>
            </div>
          </div>
          @endcan
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          @include('dental_management.appointments.partials.index_results')
        </div>
      </div>
      <div class="card-footer">
        <div class="d-flex justify-content-end">
          {{ $appointments->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
