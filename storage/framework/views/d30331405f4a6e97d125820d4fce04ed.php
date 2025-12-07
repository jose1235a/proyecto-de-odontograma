<?php
    $formIdentifier = $formIdentifier ?? 'odontogram_form';
    $shouldPrefillForm = old('form_identifier') === $formIdentifier;
    $selectedDoctorId = $shouldPrefillForm ? old('doctor_id') : ($selectedDoctorId ?? null);
    $descriptionValue = $shouldPrefillForm ? old('description') : ($descriptionValue ?? '');
?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/odontogram/partials/form_setup.blade.php ENDPATH**/ ?>