<form id="form-save" action="{{ route('dental_management.patients.update', $patient) }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
  @csrf
  @method('PUT')

<!-- Fila 1: Foto del paciente -->
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="photo">{{ __('dental_management.patients.photo') }}</label>
      <div class="row">
        <div class="col-md-6">
          <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
          <small class="form-text text-muted">{{ __('dental_management.patients.photo_help') }}</small>
          @if($patient->photo_url && !filter_var($patient->photo_url, FILTER_VALIDATE_URL))
            <div class="mt-2">
              <small class="text-muted">{{ __('dental_management.patients.current_photo') }}:</small><br>
              <img src="{{ $patient->photo_url }}" alt="Foto actual" class="img-thumbnail mt-1" style="max-height: 100px;">
            </div>
          @endif
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
        <option value="dni" {{ old('document_type', $patient->document_type) == 'dni' || $patient->document_type == 'dni' ? 'selected' : '' }}>DNI</option>
        <option value="passport" {{ old('document_type', $patient->document_type) == 'passport' || $patient->document_type == 'passport' ? 'selected' : '' }}>Pasaporte</option>
        <option value="other" {{ old('document_type', $patient->document_type) == 'other' || $patient->document_type == 'other' ? 'selected' : '' }}>Otro</option>
      </select>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="document">{{ __('dental_management.patients.document') }} <span class="text-danger">(*)</span></label>
      <input type="text" name="document" id="document" class="form-control" required
             value="{{ old('document', $patient->document) }}" data-parsley-minlength="8"
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.document')]) }}">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="name">{{ __('dental_management.patients.name') }} <span class="text-danger">(*)</span></label>
      <input type="text" name="name" id="name" class="form-control" required
             value="{{ old('name', $patient->name) }}" data-parsley-minlength="3"
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.name')]) }}">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="last_name">{{ __('dental_management.patients.last_name') }} <span class="text-danger">(*)</span></label>
      <input type="text" name="last_name" id="last_name" class="form-control" required
             value="{{ old('last_name', $patient->last_name) }}" data-parsley-minlength="3"
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.last_name')]) }}">
    </div>
  </div>
</div>

<!-- Fila 3: 4 columnas - Datos personales -->
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="gender">{{ __('dental_management.patients.gender') }}</label>
      <select name="gender" id="gender" class="form-control">
        <option value="">{{ __('global.select_option') }}</option>
        <option value="M" {{ old('gender', $patient->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
        <option value="F" {{ old('gender', $patient->gender) == 'F' ? 'selected' : '' }}>Femenino</option>
      </select>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="birth_date">{{ __('dental_management.patients.birth_date') }}</label>
      <input type="date" name="birth_date" id="birth_date" class="form-control"
             value="{{ old('birth_date', $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '') }}">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="email">{{ __('dental_management.patients.email') }} <span class="text-danger">(*)</span></label>
      <input type="email" name="email" id="email" class="form-control" required
             value="{{ old('email', $patient->email) }}"
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.email')]) }}">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="phone">{{ __('dental_management.patients.phone') }}</label>
      <input type="text" name="phone" id="phone" class="form-control"
             value="{{ old('phone', $patient->phone) }}"
             placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.phone')]) }}">
    </div>
  </div>
</div>

<!-- Fila 4: 3 columnas - Dirección y contacto -->
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="address">{{ __('dental_management.patients.address') }}</label>
      <textarea name="address" id="address" class="form-control" rows="2"
                placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.address')]) }}">{{ old('address', $patient->address) }}</textarea>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="emergency_contact">{{ __('dental_management.patients.emergency_contact') }}</label>
      <textarea name="emergency_contact" id="emergency_contact" class="form-control" rows="2"
                placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.emergency_contact')]) }}">{{ old('emergency_contact', $patient->emergency_contact) }}</textarea>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="referred_by">{{ __('dental_management.patients.referred_by') }}</label>
      <input type="text" name="referred_by" id="referred_by" class="form-control"
             value="{{ old('referred_by', $patient->referred_by) }}"
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
        <option value="1" {{ old('under_medical_treatment', $patient->under_medical_treatment) == 1 || $patient->under_medical_treatment == 1 ? 'selected' : '' }}>{{ __('global.yes') }}</option>
        <option value="0" {{ old('under_medical_treatment', $patient->under_medical_treatment) == 0 || $patient->under_medical_treatment == 0 ? 'selected' : '' }}>{{ __('global.no') }}</option>
      </select>
      <textarea name="under_medical_treatment_description" id="under_medical_treatment_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="{{ __('dental_management.patients.description_placeholder') }}">{{ old('under_medical_treatment_description', $patient->under_medical_treatment_description) }}</textarea>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="prone_to_bleeding">{{ __('dental_management.patients.prone_to_bleeding') }}</label>
      <select name="prone_to_bleeding" id="prone_to_bleeding" class="form-control">
        <option value="">{{ __('global.select_option') }}</option>
        <option value="1" {{ old('prone_to_bleeding', $patient->prone_to_bleeding) == 1 || $patient->prone_to_bleeding == 1 ? 'selected' : '' }}>{{ __('global.yes') }}</option>
        <option value="0" {{ old('prone_to_bleeding', $patient->prone_to_bleeding) == 0 || $patient->prone_to_bleeding == 0 ? 'selected' : '' }}>{{ __('global.no') }}</option>
      </select>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="allergic_to_medication">{{ __('dental_management.patients.allergic_to_medication') }}</label>
      <select name="allergic_to_medication" id="allergic_to_medication" class="form-control medical-select">
        <option value="">{{ __('global.select_option') }}</option>
        <option value="1" {{ old('allergic_to_medication', $patient->allergic_to_medication) == 1 || $patient->allergic_to_medication == 1 ? 'selected' : '' }}>{{ __('global.yes') }}</option>
        <option value="0" {{ old('allergic_to_medication', $patient->allergic_to_medication) == 0 || $patient->allergic_to_medication == 0 ? 'selected' : '' }}>{{ __('global.no') }}</option>
      </select>
      <textarea name="allergic_to_medication_description" id="allergic_to_medication_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="{{ __('dental_management.patients.description_placeholder') }}">{{ old('allergic_to_medication_description', $patient->allergic_to_medication_description) }}</textarea>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="hypertensive">{{ __('dental_management.patients.hypertensive') }}</label>
      <select name="hypertensive" id="hypertensive" class="form-control">
        <option value="">{{ __('global.select_option') }}</option>
        <option value="1" {{ old('hypertensive', $patient->hypertensive) == 1 || $patient->hypertensive == 1 ? 'selected' : '' }}>{{ __('global.yes') }}</option>
        <option value="0" {{ old('hypertensive', $patient->hypertensive) == 0 || $patient->hypertensive == 0 ? 'selected' : '' }}>{{ __('global.no') }}</option>
      </select>
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
        <option value="1" {{ old('diabetic', $patient->diabetic) == 1 || $patient->diabetic == 1 ? 'selected' : '' }}>{{ __('global.yes') }}</option>
        <option value="0" {{ old('diabetic', $patient->diabetic) == 0 || $patient->diabetic == 0 ? 'selected' : '' }}>{{ __('global.no') }}</option>
      </select>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="pregnant">{{ __('dental_management.patients.pregnant') }}</label>
      <select name="pregnant" id="pregnant" class="form-control medical-select">
        <option value="">{{ __('global.select_option') }}</option>
        <option value="1" {{ old('pregnant', $patient->pregnant) == 1 || $patient->pregnant == 1 ? 'selected' : '' }}>{{ __('global.yes') }}</option>
        <option value="0" {{ old('pregnant', $patient->pregnant) == 0 || $patient->pregnant == 0 ? 'selected' : '' }}>{{ __('global.no') }}</option>
      </select>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="observations">{{ __('dental_management.patients.observations') }}</label>
      <textarea name="observations" id="observations" class="form-control" rows="2"
                placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.observations')]) }}">{{ old('observations', $patient->observations) }}</textarea>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="custom-control custom-checkbox">
    <input type="checkbox" name="is_active" id="is_active" class="custom-control-input"
           value="1" {{ old('is_active', $patient->is_active) == 1 || $patient->is_active == 1 ? 'checked' : '' }}>
    <label class="custom-control-label" for="is_active">
      {{ __('dental_management.patients.is_active') }}
    </label>
  </div>
</div>
</form>