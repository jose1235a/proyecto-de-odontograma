<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_by') }}</label>
      <p class="form-control-plaintext">{{ $patient->creator->name ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_at') }}</label>
      <p class="form-control-plaintext">{{ $patient->created_at ? $patient->created_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.updated_at') }}</label>
      <p class="form-control-plaintext">{{ $patient->updated_at ? $patient->updated_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_by') }}</label>
      <p class="form-control-plaintext">{{ $patient->deleter->name ?? '-' }}</p>
    </div>
  </div>
</div>

@if($patient->deleted_at)
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_at') }}</label>
      <p class="form-control-plaintext">{{ $patient->deleted_at ? $patient->deleted_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_reason') }}</label>
      <p class="form-control-plaintext">{{ $patient->deleted_description ?? '-' }}</p>
    </div>
  </div>
</div>
@endif