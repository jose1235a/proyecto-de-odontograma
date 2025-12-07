<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="name">{{ __('dental_management.specialties.name') }}</label>
      <input type="text" class="form-control" id="name" name="name"
             value="{{ request('name') }}" placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.specialties.name')]) }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="is_active">{{ __('global.status') }}</label>
      <select class="form-control" id="is_active" name="is_active">
        <option value="">{{ __('global.all') }}</option>
        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
      </select>
    </div>
  </div>
</div>