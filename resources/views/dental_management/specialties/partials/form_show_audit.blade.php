<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_by') }}</label>
      <p class="form-control-plaintext">{{ $specialty->creator->name ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_at') }}</label>
      <p class="form-control-plaintext">{{ $specialty->created_at ? $specialty->created_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.updated_at') }}</label>
      <p class="form-control-plaintext">{{ $specialty->updated_at ? $specialty->updated_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_by') }}</label>
      <p class="form-control-plaintext">{{ $specialty->deleter->name ?? '-' }}</p>
    </div>
  </div>
</div>

@if($specialty->deleted_at)
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_at') }}</label>
      <p class="form-control-plaintext">{{ $specialty->deleted_at ? $specialty->deleted_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_reason') }}</label>
      <p class="form-control-plaintext">{{ $specialty->deleted_description ?? '-' }}</p>
    </div>
  </div>
</div>
@endif