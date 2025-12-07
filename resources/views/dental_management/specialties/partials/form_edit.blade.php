<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="name" class="required">{{ __('dental_management.specialties.name') }}</label>
      <input type="text" class="form-control" id="name" name="name"
             value="{{ old('name', $specialty->name) }}" required
             placeholder="{{ __('global.placeholders.enter_attribute', ['attribute' => __('dental_management.specialties.name')]) }}">
      @error('name')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="is_active">{{ __('global.status') }}</label>
      <select class="form-control" id="is_active" name="is_active">
        <option value="1" {{ old('is_active', $specialty->is_active) == '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
        <option value="0" {{ old('is_active', $specialty->is_active) == '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
      </select>
      @error('is_active')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>
  </div>
</div>