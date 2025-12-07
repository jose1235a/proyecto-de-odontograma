<form id="form-delete" action="{{ route('dental_management.payments.deleteSave', $payment) }}" method="POST">
  @csrf
  @method('DELETE')
  @if(!empty($returnUrl))
  <input type="hidden" name="return_url" value="{{ $returnUrl }}">
  @endif

  <div class="form-group">
    <label for="reason">{{ __('dental_management.payments.fields.delete_reason') }} <span class="text-danger">(*)</span></label>
    <textarea name="reason" id="reason" class="form-control" rows="4" required
              placeholder="{{ __('global.placeholders.enter_delete_reason') }}"
              minlength="10" maxlength="500"></textarea>
    <small class="form-text text-muted">{{ __('global.min_characters', ['count' => 10]) }}</small>
    @error('reason')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</form>