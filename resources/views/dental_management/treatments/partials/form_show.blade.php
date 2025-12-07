<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.treatments.name') }}</label>
      <p class="form-control-plaintext">{{ $treatment->name }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.treatments.cost') }}</label>
      <p class="form-control-plaintext">{{ $treatment->getCostFormattedAttribute() }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.treatments.coverage') }}</label>
      <p class="form-control-plaintext">
        @php
            $coverageKey = $treatment->coverage === 'full' ? 'coverage_full' : 'coverage_partial';
            $badgeClass = $treatment->coverage === 'full' ? 'badge-info' : 'badge-secondary';
        @endphp
        <span class="badge {{ $badgeClass }}">
          {{ __('dental_management.treatments.' . $coverageKey) }}
        </span>
      </p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('dental_management.treatments.is_active') }}</label>
      <p class="form-control-plaintext">
        @if($treatment->is_active)
          <span class="badge badge-success">{{ __('global.active') }}</span>
        @else
          <span class="badge badge-danger">{{ __('global.inactive') }}</span>
        @endif
      </p>
    </div>
  </div>
</div>

<div class="form-group">
  <label>{{ __('dental_management.treatments.description') }}</label>
  <p class="form-control-plaintext">{{ $treatment->description ?? '-' }}</p>
</div>
