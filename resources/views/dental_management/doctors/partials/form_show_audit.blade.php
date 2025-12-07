<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_by') }}</label>
      <p class="form-control-plaintext">{{ $doctor->creator->name ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_at') }}</label>
      <p class="form-control-plaintext">{{ $doctor->created_at ? $doctor->created_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.updated_at') }}</label>
      <p class="form-control-plaintext">{{ $doctor->updated_at ? $doctor->updated_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_by') }}</label>
      <p class="form-control-plaintext">{{ $doctor->deleter->name ?? '-' }}</p>
    </div>
  </div>
</div>

@if($doctor->deleted_at)
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_at') }}</label>
      <p class="form-control-plaintext">{{ $doctor->deleted_at ? $doctor->deleted_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_reason') }}</label>
      <p class="form-control-plaintext">{{ $doctor->deleted_description ?? '-' }}</p>
    </div>
  </div>
</div>
@endif