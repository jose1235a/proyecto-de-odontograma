<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_by') }}</label>
      <p class="form-control-plaintext">{{ $appointment->creator->name ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_at') }}</label>
      <p class="form-control-plaintext">{{ $appointment->created_at ? $appointment->created_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.updated_at') }}</label>
      <p class="form-control-plaintext">{{ $appointment->updated_at ? $appointment->updated_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_by') }}</label>
      <p class="form-control-plaintext">{{ $appointment->deleter->name ?? '-' }}</p>
    </div>
  </div>
</div>

@if($appointment->deleted_at)
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ __('global.deleted_at') }}</label>
        <p class="form-control-plaintext">{{ $appointment->deleted_at ? $appointment->deleted_at->format('d/m/Y H:i') : '-' }}</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ __('global.deleted_reason') }}</label>
        <p class="form-control-plaintext">{{ $appointment->deleted_description ?? '-' }}</p>
      </div>
    </div>
  </div>
@endif
