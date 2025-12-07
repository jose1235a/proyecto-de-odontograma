<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.appointments.treatment') }}</label>
      <p class="form-control-plaintext">{{ $appointment->treatment->name ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.appointments.doctor') }}</label>
      <p class="form-control-plaintext">
        {{ $appointment->doctor ? trim($appointment->doctor->name . ' ' . $appointment->doctor->last_name) : '-' }}
      </p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.appointments.patient') }}</label>
      <p class="form-control-plaintext">
        {{ $appointment->patient ? trim($appointment->patient->name . ' ' . $appointment->patient->last_name) : '-' }}
      </p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.appointments.date') }}</label>
      <p class="form-control-plaintext">{{ $appointment->appointment_date ? $appointment->appointment_date->format('d/m/Y') : '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.appointments.time') }}</label>
      <p class="form-control-plaintext">{{ $appointment->appointment_time ? $appointment->appointment_time->format('H:i') : '-' }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.appointments.cost') }}</label>
      <p class="form-control-plaintext">${{ number_format($appointment->cost ?? 0, 2) }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.appointments.paid') }}</label>
      <p class="form-control-plaintext">${{ number_format($appointment->paid ?? 0, 2) }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.appointments.status') }}</label>
      <p class="form-control-plaintext">{!! $appointment->status_html !!}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.appointments.notes') }}</label>
      <p class="form-control-plaintext">{{ $appointment->notes ?? '-' }}</p>
    </div>
  </div>
</div>
