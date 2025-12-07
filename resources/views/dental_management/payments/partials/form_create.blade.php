<form id="form-save" action="{{ route('dental_management.payments.store') }}" method="POST" data-parsley-validate>
  @csrf

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="patient_id">{{ __('dental_management.payments.fields.patient') }} <span class="text-danger">(*)</span></label>
        @if(isset($patient) && $patient)
          <input type="hidden" name="patient_id" value="{{ $patient->id }}">
          <input type="text" class="form-control" value="{{ $patient->name }} {{ $patient->last_name }}" readonly>
        @else
          <select name="patient_id" id="patient_id" class="form-control select2" required>
            <option value="">{{ __('global.select_option') }}</option>
            @foreach(\App\Models\Patient::notDeleted()->orderBy('name')->get() as $patientOption)
              <option value="{{ $patientOption->id }}" {{ old('patient_id') == $patientOption->id ? 'selected' : '' }}>
                {{ $patientOption->name }} {{ $patientOption->last_name }} - {{ $patientOption->document }}
              </option>
            @endforeach
          </select>
        @endif
        @error('patient_id')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="appointment_id">{{ __('dental_management.payments.fields.appointment') }}</label>
        <select name="appointment_id" id="appointment_id" class="form-control select2">
          <option value="">Seleccionar cita</option>
          @if(isset($appointments) && $appointments->count() > 0)
            @foreach($appointments as $appointment)
              <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                {{ $appointment->appointment_date->format('d/m/Y') }} {{ $appointment->appointment_time ? $appointment->appointment_time->format('H:i') : 'N/A' }} - {{ $appointment->treatment->name ?? 'Sin tratamiento' }}
              </option>
            @endforeach
          @endif
        </select>
        @error('appointment_id')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="amount">{{ __('dental_management.payments.fields.amount') }} <span class="text-danger">(*)</span></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">S/</span>
          </div>
          <input type="number" name="amount" id="amount" class="form-control"
                 value="{{ old('amount') }}" step="0.01" min="0.01" max="999999.99" required>
        </div>
        @error('amount')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="payment_date">{{ __('dental_management.payments.fields.payment_date') }} <span class="text-danger">(*)</span></label>
        <input type="date" name="payment_date" id="payment_date" class="form-control"
               value="{{ old('payment_date', date('Y-m-d')) }}" required>
        @error('payment_date')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="payment_method">{{ __('dental_management.payments.fields.payment_method') }} <span class="text-danger">(*)</span></label>
        <select name="payment_method" id="payment_method" class="form-control" required>
          <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>{{ __('dental_management.payments.methods.cash') }}</option>
          <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>{{ __('dental_management.payments.methods.card') }}</option>
          <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>{{ __('dental_management.payments.methods.transfer') }}</option>
          <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>{{ __('dental_management.payments.methods.check') }}</option>
        </select>
        @error('payment_method')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="status">{{ __('dental_management.payments.fields.status') }} <span class="text-danger">(*)</span></label>
        <select name="status" id="status" class="form-control" required>
          <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>{{ __('dental_management.payments.status_values.pending') }}</option>
          <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('dental_management.payments.status_values.completed') }}</option>
          <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>{{ __('dental_management.payments.status_values.cancelled') }}</option>
          <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>{{ __('dental_management.payments.status_values.refunded') }}</option>
        </select>
        @error('status')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="reference_number">{{ __('dental_management.payments.fields.reference_number') }}</label>
    <input type="text" name="reference_number" id="reference_number" class="form-control"
           value="{{ old('reference_number') }}" maxlength="50">
    @error('reference_number')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label for="notes">{{ __('dental_management.payments.fields.notes') }}</label>
    <textarea name="notes" id="notes" class="form-control" rows="3" maxlength="500">{{ old('notes') }}</textarea>
    @error('notes')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</form>