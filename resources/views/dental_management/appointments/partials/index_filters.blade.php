<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="patient">{{ __('dental_management.appointments.patient') }}</label>
      <input
        type="text"
        class="form-control"
        id="patient"
        name="patient"
        value="{{ request('patient') }}"
        placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.appointments.patient')]) }}"
      >
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="treatment_id">{{ __('dental_management.appointments.treatment') }}</label>
      <select class="form-control" id="treatment_id" name="treatment_id">
        <option value="">{{ __('global.all') }}</option>
        @foreach($treatments as $treatment)
          <option value="{{ $treatment->id }}" {{ (string) request('treatment_id') === (string) $treatment->id ? 'selected' : '' }}>
            {{ $treatment->name }}
          </option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="doctor_id">{{ __('dental_management.appointments.doctor') }}</label>
      <select class="form-control" id="doctor_id" name="doctor_id">
        <option value="">{{ __('global.all') }}</option>
        @foreach($doctors as $doctor)
          @php($doctorName = trim($doctor->name . ' ' . ($doctor->last_name ?? '')))
          <option value="{{ $doctor->id }}" {{ (string) request('doctor_id') === (string) $doctor->id ? 'selected' : '' }}>
            {{ $doctorName }}
          </option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="status">{{ __('dental_management.appointments.status') }}</label>
      <select class="form-control" id="status" name="status">
        <option value="">{{ __('global.all') }}</option>
        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>
          {{ __('dental_management.appointments.status_assigned') }}
        </option>
        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>
          {{ __('dental_management.appointments.status_attended') }}
        </option>
        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
          {{ __('dental_management.appointments.status_cancelled') }}
        </option>
      </select>
    </div>
  </div>
</div>

<div class="row">
  <!-- Removed date filter per request -->
</div>
