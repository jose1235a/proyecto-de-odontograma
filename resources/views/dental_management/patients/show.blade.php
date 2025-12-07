@extends('layouts.app')

@section('title', __('dental_management.patients.show_title'))
@section('title_navbar', __('dental_management.patients.plural'))

@section('content')
@include('dental_management.odontogram.partials.patient_conditions_alert', ['patient' => $patient])

<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-database"></i> {{ __('dental_management.patients.show_title') }}
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center mb-3">
          <div class="d-flex justify-content-center align-items-center mb-3">
            <img src="{{ $patient->photo_url }}" alt="Foto del paciente" class="rounded-circle mr-4" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #007bff;">
            <div class="text-left">
              <h3 class="font-weight-bold text-dark mb-1">{{ $patient->name }} {{ $patient->last_name }}</h3>
              <p class="h6 text-muted mb-0">
                DNI: {{ $patient->document }}
                @if($patient->birth_date)
                  || EDAD: {{ \Carbon\Carbon::parse($patient->birth_date)->age }} años
                @endif
                @if($patient->phone)
                  || TEL: {{ $patient->phone }}
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-center">
        <a href="{{ route('dental_management.patients.index') }}" class="btn btn-secondary mr-2" title="{{ __('global.back') }}">
          <i class="fas fa-arrow-left"></i> {{ __('global.back') }}
        </a>
        <a href="{{ route('dental_management.patients.edit', $patient) }}" class="btn btn-warning" title="{{ __('global.edit') }}">
          <i class="fas fa-edit"></i> {{ __('global.edit') }}
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card card-info card-tabs">
      <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="patient-tabs" role="tablist">
           <li class="nav-item">
             <a class="nav-link active" id="patient-info-tab" data-toggle="pill" href="#patient-info" role="tab" aria-controls="patient-info" aria-selected="true">
               <i class="fas fa-user"></i> {{ __('dental_management.patients.info_title') }}
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link" id="consultations-tab" data-toggle="pill" href="#consultations" role="tab" aria-controls="consultations" aria-selected="false">
               <i class="fas fa-stethoscope"></i> {{ __('dental_management.consultations.clinical_history') }}
               <span class="badge badge-light">{{ $patient->consultations->count() }}</span>
             </a>
           </li>
          <li class="nav-item">
            <a class="nav-link" id="odontograms-tab" data-toggle="pill" href="#odontograms" role="tab" aria-controls="odontograms" aria-selected="false">
              <i class="fas fa-tooth"></i> {{ __('dental_management.odontogram.plural') }}
              <span class="badge badge-light">{{ $patient->odontograms->count() }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="appointments-tab" data-toggle="pill" href="#appointments" role="tab" aria-controls="appointments" aria-selected="false">
              <i class="fas fa-calendar-alt"></i> {{ __('dental_management.appointments.plural') }}
              <span class="badge badge-light">{{ $patient->appointments->count() }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="payments-tab" data-toggle="pill" href="#payments" role="tab" aria-controls="payments" aria-selected="false">
              <i class="fas fa-money-bill-wave"></i> {{ __('dental_management.payments.plural') }}
              <span class="badge badge-light">{{ $payments->count() }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="images-tab" data-toggle="pill" href="#images" role="tab" aria-controls="images" aria-selected="false">
              <i class="fas fa-images"></i> {{ __('dental_management.patients.images') }}
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="patient-tabs-content">
           <!-- Patient Info Tab -->
           <div class="tab-pane fade show active" id="patient-info" role="tabpanel" aria-labelledby="patient-info-tab">
             @include('dental_management.patients.partials.form_show')

              @include('dental_management.patients.partials.audit_card')
           </div>

            <!-- Consultations Tab -->
            <div class="tab-pane fade" id="consultations" role="tabpanel" aria-labelledby="consultations-tab">
            <div class="row">
              <div class="col-lg-12">
                <div class="card card-info rounded">
                  <div class="card-header">
                    <h3 class="card-title pt-1">
                      <i class="fas fa-table"></i> {{ __('global.card_title_result') }}:
                      @if ($patient->consultations->count() > 0)
                        {{ $patient->consultations->count() }}
                      @else
                        0
                      @endif
                    </h3>
                    <div class="card-tools">
                      <a class="btn btn-sm btn-success mr-2" href="{{ route('dental_management.consultations.create') }}?patient_id={{ $patient->slug }}">
                        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('dental_management.consultations.new_consultation') }}</span>
                      </a>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    @if($patient->consultations->count() > 0)
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="patient-consultations-table">
                          <thead>
                            <tr>
                              <th>{{ __('dental_management.consultations.consultation_date') }}</th>
                              <th>{{ __('dental_management.consultations.description') }}</th>
                              <th>{{ __('dental_management.consultations.doctor') }}</th>
                              <th>{{ __('global.actions') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $consultations = $patient->consultations->sort(function ($a, $b) {
                                    $aDate = $a->consultation_date ? $a->consultation_date->timestamp : 0;
                                    $bDate = $b->consultation_date ? $b->consultation_date->timestamp : 0;
                                    if ($aDate != $bDate) {
                                        return $bDate - $aDate; // Descending date
                                    }
                                    $aTime = $a->consultation_time ? strtotime($a->consultation_time->format('H:i:s')) : 0;
                                    $bTime = $b->consultation_time ? strtotime($b->consultation_time->format('H:i:s')) : 0;
                                    return $bTime - $aTime; // Descending time
                                });
                                $firstConsultation = $consultations->first();
                            @endphp
                            @foreach($consultations as $index => $consultation)
                              <tr>
                                <td data-order="{{ $consultation->consultation_date ? $consultation->consultation_date->timestamp : 0 }}">
                                  @if($consultation->consultation_date && $consultation->consultation_time)
                                    {{ $consultation->consultation_date->format('d/m/Y') }} {{ $consultation->consultation_time->format('H:i') }}
                                  @else
                                    -
                                  @endif
                                </td>
                                <td>{{ $consultation->treatment->name ?? '-' }}</td>
                                <td>{{ $consultation->doctor->name ?? '-' }}</td>
                                <td>
                                  <div class="btn-group" role="group">
                                    <a href="{{ route('dental_management.consultations.edit', ['consultation' => $consultation, 'return_url' => route('dental_management.patients.show', $patient) . '?tab=consultations']) }}" class="btn btn-light btn-sm" title="{{ __('global.edit') }}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    @if($consultation->id !== $firstConsultation->id)
                                    <a href="{{ route('dental_management.consultations.delete', ['consultation' => $consultation, 'return_url' => route('dental_management.patients.show', $patient) . '?tab=consultations']) }}" class="btn btn-light btn-sm" title="{{ __('global.delete') }}">
                                      <i class="fas fa-trash"></i>
                                    </a>
                                    @endif
                                  </div>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    @else
                      <p class="text-center text-muted">{{ __('global.no_records') }}</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            @include('dental_management.patients.partials.audit_card')
          </div>

          <!-- Odontograms Tab -->
          <div class="tab-pane fade" id="odontograms" role="tabpanel" aria-labelledby="odontograms-tab">
            @include('dental_management.patients.partials.tabs.odontograms', ['patient' => $patient])
          </div>

          <!-- Appointments Tab -->
          <div class="tab-pane fade" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
            <div class="row">
              <div class="col-lg-12">
                <div class="card card-info rounded">
                  <div class="card-header">
                    <h3 class="card-title pt-1">
                      <i class="fas fa-table"></i> {{ __('global.card_title_result') }}:
                      @if ($patient->appointments->count() > 0)
                        {{ $patient->appointments->count() }}
                      @else
                        0
                      @endif
                    </h3>
                    <div class="card-tools">
                      <a class="btn btn-sm btn-primary mr-2" href="{{ route('dental_management.appointments.create') }}?patient_id={{ $patient->slug }}&return_url={{ urlencode(route('dental_management.patients.show', $patient) . '?tab=appointments') }}">
                        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }}</span>
                      </a>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    @if($patient->appointments->count() > 0)
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="patient-appointments-table">
                          <thead>
                            <tr>
                              <th>{{ __('dental_management.appointments.appointment_date') }}</th>
                              <th>{{ __('dental_management.doctors.singular') }}</th>
                              <th>{{ __('dental_management.treatments.singular') }}</th>
                              <th>{{ __('dental_management.appointments.status') }}</th>
                              <th>{{ __('global.actions') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $sortedAppointments = $patient->appointments->sortByDesc('appointment_date')->sortByDesc('appointment_time');
                            @endphp
                            @foreach($sortedAppointments as $appointment)
                              <tr>
                                <td data-order="{{ $appointment->appointment_date ? ($appointment->appointment_date->timestamp + ($appointment->appointment_time ? $appointment->appointment_time->hour * 3600 + $appointment->appointment_time->minute * 60 + $appointment->appointment_time->second : 0)) : 0 }}">
                                  @if($appointment->appointment_date && $appointment->appointment_time)
                                    {{ $appointment->appointment_date->format('d/m/Y') }} {{ $appointment->appointment_time->format('H:i') }}
                                  @else
                                    -
                                  @endif
                                </td>
                                <td>{{ $appointment->doctor->name ?? '-' }}</td>
                                <td>{{ $appointment->treatment->name ?? '-' }}</td>
                                <td>{!! $appointment->status_html !!}</td>
                                <td>
                                  <div class="btn-group" role="group">
                                    <a href="{{ route('dental_management.appointments.edit', ['appointment' => $appointment, 'return_url' => route('dental_management.patients.show', $patient)]) }}" class="btn btn-light btn-sm" title="{{ __('global.edit') }}">
                                      <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('dental_management.appointments.delete', ['appointment' => $appointment, 'return_url' => route('dental_management.patients.show', $patient)]) }}" class="btn btn-light btn-sm" title="{{ __('global.delete') }}">
                                      <i class="fas fa-trash"></i>
                                    </a>
                                  </div>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    @else
                      <p class="text-center text-muted">{{ __('dental_management.consultations.no_consultations') }}</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            @include('dental_management.patients.partials.audit_card')
          </div>

          <!-- Payments Tab -->
          <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
            <div class="row">
              <div class="col-lg-12">
                <div class="card card-info rounded">
                  <div class="card-header">
                    <h3 class="card-title pt-1">
                      <i class="fas fa-table"></i> {{ __('global.card_title_result') }}:
                      @if ($payments->count() > 0)
                        {{ $payments->count() }}
                      @else
                        0
                      @endif
                    </h3>
                    <div class="card-tools">
                      <a class="btn btn-sm btn-success mr-2" href="{{ route('dental_management.payments.create') }}?patient_id={{ $patient->slug }}&return_url={{ urlencode(route('dental_management.patients.show', $patient) . '?tab=payments') }}">
                        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{ __('global.create') }} {{ __('dental_management.payments.singular') }}</span>
                      </a>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('global.collapse') }}">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    @if($payments->count() > 0)
                      <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="patient-payments-table">
                          <thead>
                            <tr>
                              <th>{{ __('dental_management.payments.payment_date') }}</th>
                              <th>{{ __('dental_management.payments.amount') }}</th>
                              <th>{{ __('dental_management.payments.fields.payment_method') }}</th>
                              <th>{{ __('dental_management.payments.fields.status') }}</th>
                              <th>{{ __('global.actions') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($payments as $payment)
                              <tr>
                                <td data-order="{{ $payment->created_at->timestamp }}">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                <td><strong>{{ $payment->amount_formatted }}</strong></td>
                                <td>{!! $payment->payment_method_html !!}</td>
                                <td>{!! $payment->status_html !!}</td>
                                <td>
                                  <div class="btn-group" role="group">
                                    <a href="{{ route('dental_management.payments.edit', $payment->slug) }}?patient_id={{ $patient->id }}&return_url={{ urlencode(route('dental_management.patients.show', $patient) . '?tab=payments') }}" class="btn btn-light btn-sm" title="{{ __('global.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('dental_management.payments.delete', $payment->slug) }}?return_url={{ urlencode(route('dental_management.patients.show', $patient) . '?tab=payments') }}" class="btn btn-light btn-sm" title="{{ __('global.delete') }}">
                                      <i class="fas fa-trash"></i>
                                    </a>
                                  </div>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    @else
                      <p class="text-center text-muted">{{ __('global.no_records') }}</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            @include('dental_management.patients.partials.audit_card')
          </div>




          <!-- Images Tab -->
          <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
            @include('dental_management.patients.partials.form_show_images')

            @include('dental_management.patients.partials.audit_card')
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@once
@push('styles')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<style>
[data-odontogram-list] thead th.sorting:before,
[data-odontogram-list] thead th.sorting_asc:before,
[data-odontogram-list] thead th.sorting_desc:before,
[data-odontogram-list] thead th.sorting:after,
[data-odontogram-list] thead th.sorting_asc:after,
[data-odontogram-list] thead th.sorting_desc:after {
    content: none !important;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
@endpush
@endonce

@push('scripts')
@include('dental_management.patients.partials.show_scripts')
@endpush

@endsection
