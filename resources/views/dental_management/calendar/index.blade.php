@extends('layouts.app')

@section('title', __('dental_management.calendar.title'))
@section('title_navbar', __('dental_management.calendar.plural'))

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-calendar-alt"></i> {{ __('dental_management.calendar.title') }}
        </h3>
        <div class="card-tools">
          <a href="{{ route('dental_management.appointments.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('dental_management.appointments.create') }}</span>
          </a>
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <div id="calendar" class="p-3"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="eventModalTitle">
          <i class="fas fa-calendar-check mr-2"></i>
          <span id="eventModalTitleText"></span>
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info"><i class="fas fa-user-md"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">{{ __('dental_management.calendar.doctor') }}</span>
                <span class="info-box-number" id="eventDoctor"></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success"><i class="fas fa-procedures"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">{{ __('dental_management.calendar.treatment') }}</span>
                <span class="info-box-number" id="eventTreatment"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">{{ __('dental_management.calendar.time') }}</span>
                <span class="info-box-number" id="eventTime"></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary"><i class="fas fa-info-circle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">{{ __('dental_management.calendar.status') }}</span>
                <span class="info-box-number" id="eventStatus"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-sticky-note mr-2"></i>{{ __('dental_management.calendar.notes') }}</h3>
              </div>
              <div class="card-body">
                <p id="eventNotes" class="mb-0"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times mr-1"></i> Cerrar
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<style>
  #calendar .fc-toolbar-chunk .fc-button {
      background-color: #117a8b;
      border-color: #117a8b;
      color: #fff;
  }

  #calendar .fc-toolbar-chunk .fc-button.fc-button-active,
  #calendar .fc-toolbar-chunk .fc-button:hover {
      background-color: #0b5c67;
      border-color: #0b5c67;
      color: #fff;
  }

  #calendar .fc-daygrid-event {
      border: none;
      padding: 2px 4px;
      border-radius: 4px;
      font-size: 0.75rem;
  }

  .fc-dental-event-time {
      font-weight: 600;
      display: block;
  }

  .fc-dental-event-title {
      display: block;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
  }

  #calendar .fc-daygrid-day-number {
      font-weight: 600;
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>
@include('dental_management.calendar.partials.scripts')
@endpush
