<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="name" class="required">{{ __('dental_management.specialties.name') }}</label>
      <input type="text" class="form-control" id="name" name="name"
             value="{{ old('name') }}" required
             placeholder="{{ __('global.placeholders.enter_attribute', ['attribute' => __('dental_management.specialties.name')]) }}">
      @error('name')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>
  </div>
</div>

<input type="hidden" name="is_active" value="1">