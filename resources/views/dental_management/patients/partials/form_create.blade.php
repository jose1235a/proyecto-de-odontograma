<form id="form-save" action="{{ route('dental_management.patients.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
  @csrf

  <!-- Fila 1: Foto del paciente -->
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="photo">{{ __('dental_management.patients.photo') }}</label>
        <div class="row">
          <div class="col-md-6">
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
            <small class="form-text text-muted">{{ __('dental_management.patients.photo_help') }}</small>
          </div>
          <div class="col-md-6">
            <button type="button" id="take-photo-btn" class="btn btn-info">
              <i class="fas fa-camera"></i> {{ __('dental_management.patients.take_photo') }}
            </button>
            <small class="form-text text-muted">{{ __('dental_management.patients.take_photo_help') }}</small>
          </div>
        </div>
        <div id="camera-container" style="display: none;" class="mt-3">
          <video id="camera-preview" width="320" height="240" autoplay class="border"></video>
          <br>
          <button type="button" id="capture-btn" class="btn btn-success mt-2">
            <i class="fas fa-camera"></i> {{ __('dental_management.patients.capture') }}
          </button>
          <button type="button" id="cancel-camera-btn" class="btn btn-secondary mt-2 ml-2">
            <i class="fas fa-times"></i> {{ __('global.cancel') }}
          </button>
        </div>
        <canvas id="photo-canvas" style="display: none;"></canvas>
      </div>
    </div>
  </div>

  <!-- Fila 2: 4 columnas - Documento y Nombres -->
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="document_type">{{ __('dental_management.patients.document_type') }} <span class="text-danger">(*)</span></label>
        <select name="document_type" id="document_type" class="form-control" required>
          <option value="">{{ __('global.select_option') }}</option>
          <option value="dni" {{ old('document_type') == 'dni' ? 'selected' : '' }}>DNI</option>
          <option value="ruc" {{ old('document_type') == 'ruc' ? 'selected' : '' }}>RUC</option>
        </select>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="document">{{ __('dental_management.patients.document') }} <span class="text-danger">(*)</span></label>
        <input type="text" name="document" id="document" class="form-control" required
               value="{{ old('document') }}" data-parsley-minlength="8"
               placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.document')]) }}">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="name">{{ __('dental_management.patients.name') }} <span class="text-danger">(*)</span></label>
        <input type="text" name="name" id="name" class="form-control" required
               value="{{ old('name') }}" data-parsley-minlength="3"
               placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.name')]) }}">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="last_name">{{ __('dental_management.patients.last_name') }} <span class="text-danger">(*)</span></label>
        <input type="text" name="last_name" id="last_name" class="form-control" required
               value="{{ old('last_name') }}" data-parsley-minlength="3"
               placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.last_name')]) }}">
      </div>
    </div>
  </div>

  <!-- Fila 2: 4 columnas - Datos personales -->
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="gender">{{ __('dental_management.patients.gender') }} <span class="text-danger">(*)</span></label>
        <select name="gender" id="gender" class="form-control" required>
          <option value="">{{ __('global.select_option') }}</option>
          <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
          <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Femenino</option>
        </select>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="birth_date">{{ __('dental_management.patients.birth_date') }}</label>
        <input type="date" name="birth_date" id="birth_date" class="form-control"
               value="{{ old('birth_date') }}">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="email">{{ __('dental_management.patients.email') }}</label>
        <input type="email" name="email" id="email" class="form-control"
               value="{{ old('email') }}"
               placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.email')]) }}">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="phone">{{ __('dental_management.patients.phone') }}</label>
        <input type="text" name="phone" id="phone" class="form-control"
               value="{{ old('phone') }}"
               placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.phone')]) }}">
      </div>
    </div>
  </div>

  <!-- Fila 3: 4 columnas - Dirección y contacto -->
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="address">{{ __('dental_management.patients.address') }}</label>
        <textarea name="address" id="address" class="form-control" rows="2"
                  placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.address')]) }}">{{ old('address') }}</textarea>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="emergency_contact">{{ __('dental_management.patients.emergency_contact') }}</label>
        <textarea name="emergency_contact" id="emergency_contact" class="form-control" rows="2"
                  placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.emergency_contact')]) }}">{{ old('emergency_contact') }}</textarea>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="referred_by">{{ __('dental_management.patients.referred_by') }}</label>
        <input type="text" name="referred_by" id="referred_by" class="form-control"
               value="{{ old('referred_by') }}"
               placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.referred_by')]) }}">
      </div>
    </div>

  </div>

  <h5 class="mt-4 mb-3">{{ __('dental_management.patients.medical_history_title') }}</h5>

  <!-- Fila 1: 4 columnas - Condiciones médicas principales -->
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="under_medical_treatment">{{ __('dental_management.patients.under_medical_treatment') }}</label>
        <select name="under_medical_treatment" id="under_medical_treatment" class="form-control medical-select">
          <option value="">{{ __('global.select_option') }}</option>
          <option value="1" {{ old('under_medical_treatment') == '1' ? 'selected' : '' }}>{{ __('global.yes') }}</option>
          <option value="0" {{ old('under_medical_treatment') == '0' ? 'selected' : '' }}>{{ __('global.no') }}</option>
        </select>
        <textarea name="under_medical_treatment_description" id="under_medical_treatment_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="{{ __('dental_management.patients.description_placeholder') }}">{{ old('under_medical_treatment_description') }}</textarea>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="prone_to_bleeding">{{ __('dental_management.patients.prone_to_bleeding') }}</label>
        <select name="prone_to_bleeding" id="prone_to_bleeding" class="form-control medical-select">
          <option value="">{{ __('global.select_option') }}</option>
          <option value="1" {{ old('prone_to_bleeding') == '1' ? 'selected' : '' }}>{{ __('global.yes') }}</option>
          <option value="0" {{ old('prone_to_bleeding') == '0' ? 'selected' : '' }}>{{ __('global.no') }}</option>
        </select>
        <textarea name="prone_to_bleeding_description" id="prone_to_bleeding_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="{{ __('dental_management.patients.description_placeholder') }}">{{ old('prone_to_bleeding_description') }}</textarea>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="allergic_to_medication">{{ __('dental_management.patients.allergic_to_medication') }}</label>
        <select name="allergic_to_medication" id="allergic_to_medication" class="form-control medical-select">
          <option value="">{{ __('global.select_option') }}</option>
          <option value="1" {{ old('allergic_to_medication') == '1' ? 'selected' : '' }}>{{ __('global.yes') }}</option>
          <option value="0" {{ old('allergic_to_medication') == '0' ? 'selected' : '' }}>{{ __('global.no') }}</option>
        </select>
        <textarea name="allergic_to_medication_description" id="allergic_to_medication_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="{{ __('dental_management.patients.description_placeholder') }}">{{ old('allergic_to_medication_description') }}</textarea>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="hypertensive">{{ __('dental_management.patients.hypertensive') }}</label>
        <select name="hypertensive" id="hypertensive" class="form-control medical-select">
          <option value="">{{ __('global.select_option') }}</option>
          <option value="1" {{ old('hypertensive') == '1' ? 'selected' : '' }}>{{ __('global.yes') }}</option>
          <option value="0" {{ old('hypertensive') == '0' ? 'selected' : '' }}>{{ __('global.no') }}</option>
        </select>
        <textarea name="hypertensive_description" id="hypertensive_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="{{ __('dental_management.patients.description_placeholder') }}">{{ old('hypertensive_description') }}</textarea>
      </div>
    </div>
  </div>

  <!-- Fila 2: 3 columnas - Condiciones adicionales -->
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="diabetic">{{ __('dental_management.patients.diabetic') }}</label>
        <select name="diabetic" id="diabetic" class="form-control medical-select">
          <option value="">{{ __('global.select_option') }}</option>
          <option value="1" {{ old('diabetic') == '1' ? 'selected' : '' }}>{{ __('global.yes') }}</option>
          <option value="0" {{ old('diabetic') == '0' ? 'selected' : '' }}>{{ __('global.no') }}</option>
        </select>
        <textarea name="diabetic_description" id="diabetic_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="{{ __('dental_management.patients.description_placeholder') }}">{{ old('diabetic_description') }}</textarea>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label for="pregnant">{{ __('dental_management.patients.pregnant') }}</label>
        <select name="pregnant" id="pregnant" class="form-control medical-select">
          <option value="">{{ __('global.select_option') }}</option>
          <option value="1" {{ old('pregnant') == '1' ? 'selected' : '' }}>{{ __('global.yes') }}</option>
          <option value="0" {{ old('pregnant') == '0' ? 'selected' : '' }}>{{ __('global.no') }}</option>
        </select>
        <textarea name="pregnant_description" id="pregnant_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="{{ __('dental_management.patients.description_placeholder') }}">{{ old('pregnant_description') }}</textarea>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-group">
        <label for="observations">{{ __('dental_management.patients.observations') }}</label>
        <textarea name="observations" id="observations" class="form-control" rows="2"
                  placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.observations')]) }}">{{ old('observations') }}</textarea>
      </div>
    </div>
  </div>

  <h5 class="mt-4 mb-3">{{ __('dental_management.patients.first_consultation_title') }}</h5>

  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="consultation_date">{{ __('dental_management.patients.consultation_date') }} <span class="text-danger">(*)</span></label>
        <input type="date" name="consultation_date" id="consultation_date" class="form-control" required
               value="{{ old('consultation_date', date('Y-m-d')) }}">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="consultation_time">{{ __('dental_management.patients.consultation_time') }} <span class="text-danger">(*)</span></label>
        <input type="time" name="consultation_time" id="consultation_time" class="form-control" required
               value="{{ old('consultation_time', date('H:i')) }}">
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="treatment_id">{{ __('dental_management.consultations.fields.treatment') }} <span class="text-danger">(*)</span></label>
        <select name="treatment_id" id="treatment_id" class="form-control select2" required>
          <option value="">{{ __('global.select_option') }}</option>
          @foreach(\App\Models\Treatment::active()->orderBy('name')->get() as $treatment)
            <option value="{{ $treatment->id }}" {{ old('treatment_id') == $treatment->id ? 'selected' : '' }} data-cost="{{ $treatment->cost }}">
              {{ $treatment->name }}
            </option>
          @endforeach
        </select>
        @error('treatment_id')
          <p class="text-danger mb-0">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="doctor_id">{{ __('dental_management.consultations.doctor_id') }} <span class="text-danger">(*)</span></label>
        <select name="doctor_id" id="doctor_id" class="form-control select2" required>
          <option value="">{{ __('global.select_option') }}</option>
          @foreach(\App\Models\Doctor::active()->with('specialties')->orderBy('name')->get() as $doctor)
            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
              {{ $doctor->name }} {{ $doctor->last_name ?? '' }}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="fever">{{ __('dental_management.patients.fever') }}</label>
        <input type="number" name="fever" id="fever" class="form-control" step="0.1" min="30" max="45"
               value="{{ old('fever') }}" placeholder="36.5">
        <small class="form-text text-muted">°C</small>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="blood_pressure">{{ __('dental_management.patients.blood_pressure') }}</label>
        <input type="text" name="blood_pressure" id="blood_pressure" class="form-control"
               value="{{ old('blood_pressure') }}" placeholder="120/80">
        <small class="form-text text-muted">Ej: 120/80 mmHg</small>
      </div>
    </div>

    <div class="col-md-3">
      <div class="form-group">
        <label for="consultation_cost">{{ __('dental_management.patients.consultation_cost') }}</label>
        <input type="number" name="consultation_cost" id="consultation_cost" class="form-control" step="0.01" min="0"
               value="{{ old('consultation_cost', '0.00') }}" placeholder="0.00">
        <small class="form-text text-muted">S/</small>
      </div>
    </div>

  </div>

  <div class="form-group">
    <label for="consultation_description">{{ __('dental_management.patients.consultation_description') }} <span class="text-danger">(*)</span></label>
    <textarea name="consultation_description" id="consultation_description" class="form-control" rows="3" required
              placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.consultation_description')]) }}">{{ old('consultation_description') }}</textarea>
  </div>
</form>