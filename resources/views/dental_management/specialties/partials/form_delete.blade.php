<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="reason" class="required">{{ __('global.deleted_reason') }}</label>
      <textarea class="form-control" id="reason" name="reason" rows="3" required
                placeholder="{{ __('global.placeholders.enter_delete_reason') }}"></textarea>
      @error('reason')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>
  </div>
</div>