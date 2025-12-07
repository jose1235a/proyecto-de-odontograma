<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_by') }}</label>
      <p class="form-control-plaintext">{{ $treatment->creator->name ?? '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.created_at') }}</label>
      <p class="form-control-plaintext">{{ $treatment->created_at ? $treatment->created_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.updated_at') }}</label>
      <p class="form-control-plaintext">{{ $treatment->updated_at ? $treatment->updated_at->format('d/m/Y H:i') : '-' }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_by') }}</label>
      <p class="form-control-plaintext">{{ $treatment->deleter->name ?? '-' }}</p>
    </div>
  </div>
</div>

@if($treatment->deleted_at)
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_at') }}</label>
      <p class="form-control-plaintext">{{ $treatment->deleted_at->format('d/m/Y H:i') }}</p>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>{{ __('global.deleted_reason') }}</label>
      <p class="form-control-plaintext">{{ $treatment->deleted_description ?? '-' }}</p>
    </div>
  </div>
</div>
@endif
