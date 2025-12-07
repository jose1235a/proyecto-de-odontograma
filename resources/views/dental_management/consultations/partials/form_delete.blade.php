<div class="alert alert-danger">
    <h5><i class="icon fas fa-ban"></i> ¡Atención!</h5>
    Estás a punto de eliminar la consulta de <strong>{{ $consultation->patient->name }} {{ $consultation->patient->last_name }}</strong>
    realizada el <strong>{{ $consultation->consultation_date->format('d/m/Y') }}</strong>.
    Esta acción no se puede deshacer.
</div>

<form id="form-delete" action="{{ route('dental_management.consultations.deleteSave', $consultation) }}" method="POST">
    @csrf
    @method('DELETE')

    <div class="form-group">
        <label for="reason">{{ __('dental_management.consultations.fields.reason') }} <span class="text-danger">*</span></label>
        <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror"
                  rows="3" maxlength="500" required>{{ old('reason') }}</textarea>
        @error('reason')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">Explica por qué estás eliminando esta consulta.</small>
    </div>
</form>