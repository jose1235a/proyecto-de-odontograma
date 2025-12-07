@php
    $existingPatient = optional(optional($appointment)->patient);
    $selectedTreatment = old('treatment_id', optional($appointment)->treatment_id);
    $selectedDoctor = old('doctor_id', optional($appointment)->doctor_id);
    $selectedStatus = old('status', optional($appointment)->status ?? 'scheduled');
    $isPatientLocked = isset($lockedPatient) && $lockedPatient;
    $lockedPatientId = $isPatientLocked ? $lockedPatient->id : null;
    $lockedPatientName = $isPatientLocked
        ? trim($lockedPatient->name . ' ' . ($lockedPatient->last_name ?? ''))
        : null;
    $selectedPatient = old('patient_id', $existingPatient->id ?? $lockedPatientId);
    $existingPatientName = $existingPatient->name
        ? trim($existingPatient->name . ' ' . ($existingPatient->last_name ?? ''))
        : '';
    $patientDocument = old('patient_document', $existingPatient->document);
    $patientName = old('patient_name', $existingPatientName ?: $lockedPatientName);
    $returnUrl = old('return_url', $returnUrl ?? request('return_url'));
@endphp

<form id="appointment-form" action="{{ $formAction }}" method="POST" data-parsley-validate>
  @csrf
  @if(in_array($method, ['PUT', 'PATCH']))
    @method($method)
  @endif

  <input type="hidden" name="patient_id" id="hidden_patient_id" value="{{ $selectedPatient }}">
  <input type="hidden" name="patient_name" id="patient_name" value="{{ $patientName }}">
  @if(!empty($returnUrl))
    <input type="hidden" name="return_url" value="{{ $returnUrl }}">
  @endif

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="treatment_id">{{ __('dental_management.appointments.treatment') }} <span class="text-danger">*</span></label>
        <select name="treatment_id" id="treatment_id" class="form-control select2" required>
          <option value="">{{ __('global.select_option') }}</option>
          @foreach($treatments as $treatment)
            <option
              value="{{ $treatment->id }}"
              {{ (string) $selectedTreatment === (string) $treatment->id ? 'selected' : '' }}
            >
              {{ $treatment->name }} - S/ {{ number_format($treatment->cost, 2) }}
            </option>
          @endforeach
        </select>
        @error('treatment_id')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="doctor_id">{{ __('dental_management.appointments.doctor') }} <span class="text-danger">*</span></label>
        <select name="doctor_id" id="doctor_id" class="form-control select2" required>
          <option value="">{{ __('global.select_option') }}</option>
          @foreach($doctors as $doctor)
            @php($doctorName = trim($doctor->name . ' ' . ($doctor->last_name ?? '')))
            <option value="{{ $doctor->id }}" {{ (string) $selectedDoctor === (string) $doctor->id ? 'selected' : '' }}>
              {{ $doctorName }}
            </option>
          @endforeach
        </select>
        @error('doctor_id')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="patient_select">{{ __('dental_management.appointments.patient') }} <span class="text-danger">*</span></label>
        <select name="patient_id" id="patient_select" class="form-control select2" {{ $isPatientLocked ? 'disabled' : '' }} required>
          @if(!$isPatientLocked)
            <option value="">{{ __('global.select_option') }}</option>
            @foreach($patients as $patient)
              @php($patientName = trim($patient->name . ' ' . ($patient->last_name ?? '')))
              <option value="{{ $patient->id }}" {{ (string) $selectedPatient === (string) $patient->id ? 'selected' : '' }}>
                {{ $patientName }} - {{ $patient->document }}
              </option>
            @endforeach
          @else
            <option value="{{ $lockedPatientId }}" selected>
              {{ $lockedPatientName }} - {{ $lockedPatient->document }}
            </option>
          @endif
        </select>
        @error('patient_id')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="appointment_date">{{ __('dental_management.appointments.date') }} <span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="appointment_date" name="appointment_date"
               value="{{ old('appointment_date', optional(optional($appointment)->appointment_date)->format('Y-m-d')) }}" required>
        @error('appointment_date')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="appointment_time">{{ __('dental_management.appointments.time') }} <span class="text-danger">*</span></label>
        <input type="time" class="form-control" id="appointment_time" name="appointment_time"
               value="{{ old('appointment_time', optional(optional($appointment)->appointment_time)->format('H:i')) }}" required>
        @error('appointment_time')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="notes">{{ __('dental_management.appointments.notes') }}</label>
        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', optional($appointment)->notes ?? '') }}</textarea>
      </div>
    </div>
    @if(in_array($method, ['PUT', 'PATCH']))
      <div class="col-md-6">
        <div class="form-group">
          <label for="status">{{ __('dental_management.appointments.status') }} <span class="text-danger">*</span></label>
          <select name="status" id="status" class="form-control" required>
            <option value="">Seleccione una opción</option>
            <option value="scheduled" {{ old('status', optional($appointment)->status) == 'scheduled' ? 'selected' : '' }}>Asignado</option>
            <option value="completed" {{ old('status', optional($appointment)->status) == 'completed' ? 'selected' : '' }}>Atendido</option>
            <option value="cancelled" {{ old('status', optional($appointment)->status) == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
          </select>
          @error('status')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
    @endif
  </div>
</form>
