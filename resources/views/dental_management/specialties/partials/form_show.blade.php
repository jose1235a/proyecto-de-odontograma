<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.specialties.name') }}</label>
      <p class="form-control-plaintext">{{ $specialty->name }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.status') }}</label>
      <p class="form-control-plaintext">
        @if($specialty->is_active)
          <span class="badge badge-success">{{ __('global.active') }}</span>
        @else
          <span class="badge badge-danger">{{ __('global.inactive') }}</span>
        @endif
      </p>
    </div>
  </div>
</div>