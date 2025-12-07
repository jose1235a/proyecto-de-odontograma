<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.doctors.document_type') }}</label>
      <p class="form-control-plaintext">{{ $doctor->document_type ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.doctors.document') }}</label>
      <p class="form-control-plaintext">{{ $doctor->document ?? '-' }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.doctors.name') }}</label>
      <p class="form-control-plaintext">{{ $doctor->name }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.doctors.last_name') }}</label>
      <p class="form-control-plaintext">{{ $doctor->last_name }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.doctors.email') }}</label>
      <p class="form-control-plaintext">{{ $doctor->email }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.doctors.phone') }}</label>
      <p class="form-control-plaintext">{{ $doctor->phone ?? '-' }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.doctors.specialty') }}</label>
      <p class="form-control-plaintext">
        @forelse($doctor->specialties as $specialty)
          <span class="badge badge-primary">{{ $specialty->name }}</span>
        @empty
          -
        @endforelse
      </p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.doctors.is_active') }}</label>
      <p class="form-control-plaintext">{!! $doctor->state_html !!}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>{{ __('dental_management.doctors.address') }}</label>
      <p class="form-control-plaintext">{{ $doctor->address ?? '-' }}</p>
    </div>
  </div>
</div>