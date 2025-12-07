@php
    $formIdentifier = $formIdentifier ?? 'odontogram_form';
    $shouldPrefillForm = old('form_identifier') === $formIdentifier;
    $selectedDoctorId = $shouldPrefillForm ? old('doctor_id') : ($selectedDoctorId ?? null);
    $descriptionValue = $shouldPrefillForm ? old('description') : ($descriptionValue ?? '');
@endphp