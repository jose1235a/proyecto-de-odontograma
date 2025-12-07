<form id="form-save" action="{{ route('dental_management.patient_images.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
  @csrf

  <div class="form-group">
    <label>{{ __('dental_management.patient_images.fields.patient') }}</label>
    <input type="text" class="form-control" value="{{ $patient->name }} {{ $patient->last_name }}" readonly>
    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
  </div>

  <div class="form-group">
    <label>{{ __('dental_management.patients.upload_image') }}</label>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
      <label class="custom-file-label" for="image">{{ __('global.select_file') }}</label>
    </div>
    <small class="form-text text-muted">{{ __('global.allowed_formats') }}: JPG, PNG, GIF. {{ __('global.max_size') }}: 5MB</small>
    @error('image')
      <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label>{{ __('dental_management.patients.take_photo') }}</label>
    <button type="button" class="btn btn-secondary btn-sm" id="take-photo-btn">
      <i class="fas fa-camera"></i> {{ __('dental_management.patients.take_photo') }}
    </button>
    <input type="hidden" name="photo" id="photo-data">
    <div id="photo-preview" class="mt-2" style="display: none;">
      <img id="photo-preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
    </div>
  </div>

  <div class="form-group">
    <label for="title">{{ __('dental_management.patient_images.fields.title') }} <span class="text-danger">*</span></label>
    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title') }}" required maxlength="255"
           placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patient_images.fields.title')]) }}">
    @error('title')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label for="description">{{ __('dental_management.patient_images.fields.description') }}</label>
    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
              rows="3" maxlength="1000"
              placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.patient_images.fields.description')]) }}">{{ old('description') }}</textarea>
    @error('description')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</form>