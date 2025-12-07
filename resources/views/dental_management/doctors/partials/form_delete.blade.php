<div class="row">
  <div class="col-md-12">
    <div class="card card-light">
      <div class="card-header">
        <h4 class="card-title">{{ __('dental_management.doctors.delete') }}</h4>
      </div>
      <div class="card-body">
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
              <label>{{ __('dental_management.doctors.specialty') }}</label>
              <p class="form-control-plaintext">{{ $doctor->specialty->name ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<form id="form-delete" method="POST" action="{{ route('dental_management.doctors.deleteSave', $doctor) }}">
  @csrf
  @method('DELETE')

  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="reason">{{ __('global.deleted_reason') }} <span class="text-danger">*</span></label>
        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason"
                  rows="3" required maxlength="500" placeholder="{{ __('global.delete_reason_placeholder') }}">{{ old('reason') }}</textarea>
        @error('reason')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>
</form>