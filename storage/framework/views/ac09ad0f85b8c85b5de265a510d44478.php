<form id="form-save" action="<?php echo e(route('dental_management.patients.update', $patient)); ?>" method="POST" enctype="multipart/form-data" data-parsley-validate>
  <?php echo csrf_field(); ?>
  <?php echo method_field('PUT'); ?>

<!-- Fila 1: Foto del paciente -->
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="photo"><?php echo e(__('dental_management.patients.photo')); ?></label>
      <div class="row">
        <div class="col-md-6">
          <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
          <small class="form-text text-muted"><?php echo e(__('dental_management.patients.photo_help')); ?></small>
          <?php if($patient->photo_url && !filter_var($patient->photo_url, FILTER_VALIDATE_URL)): ?>
            <div class="mt-2">
              <small class="text-muted"><?php echo e(__('dental_management.patients.current_photo')); ?>:</small><br>
              <img src="<?php echo e($patient->photo_url); ?>" alt="Foto actual" class="img-thumbnail mt-1" style="max-height: 100px;">
            </div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <button type="button" id="take-photo-btn" class="btn btn-info">
            <i class="fas fa-camera"></i> <?php echo e(__('dental_management.patients.take_photo')); ?>

          </button>
          <small class="form-text text-muted"><?php echo e(__('dental_management.patients.take_photo_help')); ?></small>
        </div>
      </div>
      <div id="camera-container" style="display: none;" class="mt-3">
        <video id="camera-preview" width="320" height="240" autoplay class="border"></video>
        <br>
        <button type="button" id="capture-btn" class="btn btn-success mt-2">
          <i class="fas fa-camera"></i> <?php echo e(__('dental_management.patients.capture')); ?>

        </button>
        <button type="button" id="cancel-camera-btn" class="btn btn-secondary mt-2 ml-2">
          <i class="fas fa-times"></i> <?php echo e(__('global.cancel')); ?>

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
      <label for="document_type"><?php echo e(__('dental_management.patients.document_type')); ?> <span class="text-danger">(*)</span></label>
      <select name="document_type" id="document_type" class="form-control" required>
        <option value=""><?php echo e(__('global.select_option')); ?></option>
        <option value="dni" <?php echo e(old('document_type', $patient->document_type) == 'dni' || $patient->document_type == 'dni' ? 'selected' : ''); ?>>DNI</option>
        <option value="passport" <?php echo e(old('document_type', $patient->document_type) == 'passport' || $patient->document_type == 'passport' ? 'selected' : ''); ?>>Pasaporte</option>
        <option value="other" <?php echo e(old('document_type', $patient->document_type) == 'other' || $patient->document_type == 'other' ? 'selected' : ''); ?>>Otro</option>
      </select>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="document"><?php echo e(__('dental_management.patients.document')); ?> <span class="text-danger">(*)</span></label>
      <input type="text" name="document" id="document" class="form-control" required
             value="<?php echo e(old('document', $patient->document)); ?>" data-parsley-minlength="8"
             placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.document')])); ?>">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="name"><?php echo e(__('dental_management.patients.name')); ?> <span class="text-danger">(*)</span></label>
      <input type="text" name="name" id="name" class="form-control" required
             value="<?php echo e(old('name', $patient->name)); ?>" data-parsley-minlength="3"
             placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.name')])); ?>">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="last_name"><?php echo e(__('dental_management.patients.last_name')); ?> <span class="text-danger">(*)</span></label>
      <input type="text" name="last_name" id="last_name" class="form-control" required
             value="<?php echo e(old('last_name', $patient->last_name)); ?>" data-parsley-minlength="3"
             placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.last_name')])); ?>">
    </div>
  </div>
</div>

<!-- Fila 3: 4 columnas - Datos personales -->
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="gender"><?php echo e(__('dental_management.patients.gender')); ?></label>
      <select name="gender" id="gender" class="form-control">
        <option value=""><?php echo e(__('global.select_option')); ?></option>
        <option value="M" <?php echo e(old('gender', $patient->gender) == 'M' ? 'selected' : ''); ?>>Masculino</option>
        <option value="F" <?php echo e(old('gender', $patient->gender) == 'F' ? 'selected' : ''); ?>>Femenino</option>
      </select>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="birth_date"><?php echo e(__('dental_management.patients.birth_date')); ?></label>
      <input type="date" name="birth_date" id="birth_date" class="form-control"
             value="<?php echo e(old('birth_date', $patient->birth_date ? $patient->birth_date->format('Y-m-d') : '')); ?>">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="email"><?php echo e(__('dental_management.patients.email')); ?> <span class="text-danger">(*)</span></label>
      <input type="email" name="email" id="email" class="form-control" required
             value="<?php echo e(old('email', $patient->email)); ?>"
             placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.email')])); ?>">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="phone"><?php echo e(__('dental_management.patients.phone')); ?></label>
      <input type="text" name="phone" id="phone" class="form-control"
             value="<?php echo e(old('phone', $patient->phone)); ?>"
             placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.phone')])); ?>">
    </div>
  </div>
</div>

<!-- Fila 4: 3 columnas - Dirección y contacto -->
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="address"><?php echo e(__('dental_management.patients.address')); ?></label>
      <textarea name="address" id="address" class="form-control" rows="2"
                placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.address')])); ?>"><?php echo e(old('address', $patient->address)); ?></textarea>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="emergency_contact"><?php echo e(__('dental_management.patients.emergency_contact')); ?></label>
      <textarea name="emergency_contact" id="emergency_contact" class="form-control" rows="2"
                placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.emergency_contact')])); ?>"><?php echo e(old('emergency_contact', $patient->emergency_contact)); ?></textarea>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="referred_by"><?php echo e(__('dental_management.patients.referred_by')); ?></label>
      <input type="text" name="referred_by" id="referred_by" class="form-control"
             value="<?php echo e(old('referred_by', $patient->referred_by)); ?>"
             placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.referred_by')])); ?>">
    </div>
  </div>
</div>



<h5 class="mt-4 mb-3"><?php echo e(__('dental_management.patients.medical_history_title')); ?></h5>

<!-- Fila 1: 4 columnas - Condiciones médicas principales -->
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="under_medical_treatment"><?php echo e(__('dental_management.patients.under_medical_treatment')); ?></label>
      <select name="under_medical_treatment" id="under_medical_treatment" class="form-control medical-select">
        <option value=""><?php echo e(__('global.select_option')); ?></option>
        <option value="1" <?php echo e(old('under_medical_treatment', $patient->under_medical_treatment) == 1 || $patient->under_medical_treatment == 1 ? 'selected' : ''); ?>><?php echo e(__('global.yes')); ?></option>
        <option value="0" <?php echo e(old('under_medical_treatment', $patient->under_medical_treatment) == 0 || $patient->under_medical_treatment == 0 ? 'selected' : ''); ?>><?php echo e(__('global.no')); ?></option>
      </select>
      <textarea name="under_medical_treatment_description" id="under_medical_treatment_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="<?php echo e(__('dental_management.patients.description_placeholder')); ?>"><?php echo e(old('under_medical_treatment_description', $patient->under_medical_treatment_description)); ?></textarea>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="prone_to_bleeding"><?php echo e(__('dental_management.patients.prone_to_bleeding')); ?></label>
      <select name="prone_to_bleeding" id="prone_to_bleeding" class="form-control">
        <option value=""><?php echo e(__('global.select_option')); ?></option>
        <option value="1" <?php echo e(old('prone_to_bleeding', $patient->prone_to_bleeding) == 1 || $patient->prone_to_bleeding == 1 ? 'selected' : ''); ?>><?php echo e(__('global.yes')); ?></option>
        <option value="0" <?php echo e(old('prone_to_bleeding', $patient->prone_to_bleeding) == 0 || $patient->prone_to_bleeding == 0 ? 'selected' : ''); ?>><?php echo e(__('global.no')); ?></option>
      </select>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="allergic_to_medication"><?php echo e(__('dental_management.patients.allergic_to_medication')); ?></label>
      <select name="allergic_to_medication" id="allergic_to_medication" class="form-control medical-select">
        <option value=""><?php echo e(__('global.select_option')); ?></option>
        <option value="1" <?php echo e(old('allergic_to_medication', $patient->allergic_to_medication) == 1 || $patient->allergic_to_medication == 1 ? 'selected' : ''); ?>><?php echo e(__('global.yes')); ?></option>
        <option value="0" <?php echo e(old('allergic_to_medication', $patient->allergic_to_medication) == 0 || $patient->allergic_to_medication == 0 ? 'selected' : ''); ?>><?php echo e(__('global.no')); ?></option>
      </select>
      <textarea name="allergic_to_medication_description" id="allergic_to_medication_description" class="form-control mt-2 medical-description" rows="1" style="display: none;" placeholder="<?php echo e(__('dental_management.patients.description_placeholder')); ?>"><?php echo e(old('allergic_to_medication_description', $patient->allergic_to_medication_description)); ?></textarea>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label for="hypertensive"><?php echo e(__('dental_management.patients.hypertensive')); ?></label>
      <select name="hypertensive" id="hypertensive" class="form-control">
        <option value=""><?php echo e(__('global.select_option')); ?></option>
        <option value="1" <?php echo e(old('hypertensive', $patient->hypertensive) == 1 || $patient->hypertensive == 1 ? 'selected' : ''); ?>><?php echo e(__('global.yes')); ?></option>
        <option value="0" <?php echo e(old('hypertensive', $patient->hypertensive) == 0 || $patient->hypertensive == 0 ? 'selected' : ''); ?>><?php echo e(__('global.no')); ?></option>
      </select>
    </div>
  </div>
</div>

<!-- Fila 2: 3 columnas - Condiciones adicionales -->
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="diabetic"><?php echo e(__('dental_management.patients.diabetic')); ?></label>
      <select name="diabetic" id="diabetic" class="form-control medical-select">
        <option value=""><?php echo e(__('global.select_option')); ?></option>
        <option value="1" <?php echo e(old('diabetic', $patient->diabetic) == 1 || $patient->diabetic == 1 ? 'selected' : ''); ?>><?php echo e(__('global.yes')); ?></option>
        <option value="0" <?php echo e(old('diabetic', $patient->diabetic) == 0 || $patient->diabetic == 0 ? 'selected' : ''); ?>><?php echo e(__('global.no')); ?></option>
      </select>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="pregnant"><?php echo e(__('dental_management.patients.pregnant')); ?></label>
      <select name="pregnant" id="pregnant" class="form-control medical-select">
        <option value=""><?php echo e(__('global.select_option')); ?></option>
        <option value="1" <?php echo e(old('pregnant', $patient->pregnant) == 1 || $patient->pregnant == 1 ? 'selected' : ''); ?>><?php echo e(__('global.yes')); ?></option>
        <option value="0" <?php echo e(old('pregnant', $patient->pregnant) == 0 || $patient->pregnant == 0 ? 'selected' : ''); ?>><?php echo e(__('global.no')); ?></option>
      </select>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="observations"><?php echo e(__('dental_management.patients.observations')); ?></label>
      <textarea name="observations" id="observations" class="form-control" rows="2"
                placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patients.observations')])); ?>"><?php echo e(old('observations', $patient->observations)); ?></textarea>
    </div>
  </div>
</div>

<div class="form-group">
  <div class="custom-control custom-checkbox">
    <input type="checkbox" name="is_active" id="is_active" class="custom-control-input"
           value="1" <?php echo e(old('is_active', $patient->is_active) == 1 || $patient->is_active == 1 ? 'checked' : ''); ?>>
    <label class="custom-control-label" for="is_active">
      <?php echo e(__('dental_management.patients.is_active')); ?>

    </label>
  </div>
</div>
</form><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/patients/partials/form_edit.blade.php ENDPATH**/ ?>