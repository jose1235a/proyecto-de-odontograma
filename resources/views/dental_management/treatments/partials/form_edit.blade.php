<form id="form-save" action="{{ route('dental_management.treatments.update', $treatment) }}" method="POST" data-parsley-validate>
  @csrf
  @method('PUT')
  @if(!empty($returnUrl))
  <input type="hidden" name="return_url" value="{{ $returnUrl }}">
  @endif

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="name">{{ __('dental_management.treatments.name') }} <span class="text-danger">(*)</span></label>
        <input type="text" name="name" id="name" class="form-control"
               value="{{ old('name', $treatment->name) }}" required>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="cost">{{ __('dental_management.treatments.cost') }} <span class="text-danger">(*)</span></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">$</span>
          </div>
          <input type="number" name="cost" id="cost" class="form-control"
                 value="{{ old('cost', $treatment->cost) }}" step="0.01" min="0" max="999999.99" required>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="color">{{ __('dental_management.treatments.color') }}</label>
        <input type="color" name="color" id="color" class="form-control"
               value="{{ old('color', $treatment->color ?? '#007bff') }}" style="height: 38px;">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="coverage">{{ __('dental_management.treatments.coverage') }} <span class="text-danger">(*)</span></label>
        <select name="coverage" id="coverage" class="form-control" required>
          <option value="partial" {{ old('coverage', $treatment->coverage ?? 'partial') === 'partial' ? 'selected' : '' }}>
            {{ __('dental_management.treatments.coverage_partial') }}
          </option>
          <option value="full" {{ old('coverage', $treatment->coverage ?? 'partial') === 'full' ? 'selected' : '' }}>
            {{ __('dental_management.treatments.coverage_full') }}
          </option>
        </select>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ __('dental_management.treatments.is_active') }}</label>
        <input type="hidden" name="is_active" value="0">
        <div class="custom-control custom-switch">
          <input type="checkbox" name="is_active" id="is_active" class="custom-control-input"
                 value="1" {{ old('is_active', $treatment->is_active) ? 'checked' : '' }}>
          <label class="custom-control-label" for="is_active">{{ __('global.active') }}</label>
        </div>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="description">{{ __('dental_management.treatments.description') }}</label>
    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $treatment->description) }}</textarea>
  </div>
</form>
