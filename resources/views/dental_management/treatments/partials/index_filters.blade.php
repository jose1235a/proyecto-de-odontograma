<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="name">{{ __('dental_management.treatments.name') }}</label>
      <input
        type="text"
        name="name"
        id="name"
        class="form-control"
        value="{{ request('name') }}"
        placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('dental_management.treatments.name')]) }}"
      >
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="is_active">{{ __('dental_management.treatments.is_active') }}</label>
      <select name="is_active" id="is_active" class="form-control">
        <option value="">{{ __('global.all') }}</option>
        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>{{ __('global.active') }}</option>
        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>{{ __('global.inactive') }}</option>
      </select>
    </div>
  </div>
</div>
