<form id="form-delete" action="{{ route('dental_management.patients.deleteSave', $patient) }}" method="POST" data-parsley-validate>
  @csrf
  @method('DELETE')

  <div class="alert alert-warning">
    <h5><i class="icon fas fa-exclamation-triangle"></i> {{ __('global.warning') }}</h5>
    {{ __('global.warning_delete') }}
  </div>

  <div class="form-group">
    <label for="deleted_description">{{ __('global.delete_description') }} <span class="text-danger">(*)</span></label>
    <textarea name="reason" id="deleted_description" class="form-control" rows="3" required 
              placeholder="{{ __('global.placeholders.complete_attribute', ['attribute' => __('global.delete_description')]) }}"></textarea>
  </div>

  <hr>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ __('dental_management.patients.name') }}</label>
        <p class="form-control-plaintext">{{ $patient->name }}</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ __('dental_management.patients.email') }}</label>
        <p class="form-control-plaintext">{{ $patient->email }}</p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ __('dental_management.patients.document') }}</label>
        <p class="form-control-plaintext">{{ $patient->document ?? '-' }}</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>{{ __('dental_management.patients.phone') }}</label>
        <p class="form-control-plaintext">{{ $patient->phone ?? '-' }}</p>
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