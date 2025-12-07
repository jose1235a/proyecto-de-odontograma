<div class="alert alert-warning">
  <h5><i class="icon fas fa-exclamation-triangle"></i> {{ __('global.warning') }}</h5>
  {{ __('global.warning_delete') }}
</div>

@php
    $returnUrl = old('return_url', $returnUrl ?? request('return_url'));
@endphp

<form id="form-delete" action="{{ route('dental_management.appointments.deleteSave', $appointment) }}" method="POST" data-parsley-validate>
  @csrf
  @method('DELETE')
  @if(!empty($returnUrl))
    <input type="hidden" name="return_url" value="{{ $returnUrl }}">
  @endif

  <div class="form-group">
    <label for="reason">{{ __('global.delete_description') }} <span class="text-danger">(*)</span></label>
    <textarea name="reason" id="reason" class="form-control" rows="3" required
              placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('global.delete_description')]) }}"></textarea>
    @error('reason')
      <small class="text-danger d-block">{{ $message }}</small>
    @enderror
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label>{{ __('dental_management.appointments.patient') }}</label>
        <p class="form-control-plaintext">{{ $appointment->patient ? $appointment->patient->name . ' ' . $appointment->patient->last_name : '-' }}</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>{{ __('dental_management.appointments.doctor') }}</label>
        <p class="form-control-plaintext">{{ $appointment->doctor ? $appointment->doctor->name . ' ' . $appointment->doctor->last_name : '-' }}</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>{{ __('dental_management.appointments.treatment') }}</label>
        <p class="form-control-plaintext">{{ $appointment->treatment->name ?? '-' }}</p>
      </div>
    </div>
  </div>
</form>

@push('scripts')
<script>
function confirmDelete() {
    Swal.fire({
        title: '{{ __("global.confirm_delete") }}',
        text: '{{ __("global.confirm_delete_text") }}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __("global.yes_delete") }}',
        cancelButtonText: '{{ __("global.cancel") }}'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-delete').submit();
        }
    });
}
</script>
@endpush
