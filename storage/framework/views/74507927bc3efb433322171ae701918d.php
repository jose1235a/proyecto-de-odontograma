<!-- Select2 -->
<script src="<?php echo e(asset('adminlte/plugins/select2/js/select2.full.min.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/select2/css/select2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '<?php echo e(__("global.select_option")); ?>',
        width: '100%',
        dropdownParent: $('.modal-body, .card-body, body').first(),
        dropdownAutoWidth: true
    });
    // Set current date and time for new appointments (only if fields are empty)
    const now = new Date();
    const dateInput = document.getElementById('appointment_date');
    const timeInput = document.getElementById('appointment_time');

    if (dateInput && !dateInput.value) {
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        dateInput.value = `${year}-${month}-${day}`;
    }

    if (timeInput && !timeInput.value) {
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        timeInput.value = `${hours}:${minutes}`;
    }

    if (patientSearchButton) {
        patientSearchButton.addEventListener('click', function () {
            const documentValue = patientDocumentInput.value.trim();
            if (!documentValue) {
                updateFeedback('<?php echo e(__('dental_management.appointments.patient_search_help')); ?>', 'danger');
                return;
            }

            updateFeedback('<?php echo e(__('global.search')); ?>...', 'muted');
            fetch(searchUrl + '?document=' + encodeURIComponent(documentValue), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw response;
                    }
                    return response.json();
                })
                .then(data => {
                    const patient = data.patient || null;
                    if (!patient) {
                        updateFeedback('<?php echo e(__('dental_management.appointments.messages.patient_not_found')); ?>', 'danger');
                        return;
                    }
                    patientIdInput.value = patient.id;
                    patientNameInput.value = patient.name;
                    patientNameDisplay.value = patient.name;
                    updateFeedback('<?php echo e(__('dental_management.appointments.messages.patient_found')); ?>', 'success');
                })
                .catch(() => {
                    patientIdInput.value = '';
                    patientNameInput.value = '';
                    patientNameDisplay.value = '';
                    updateFeedback('<?php echo e(__('dental_management.appointments.messages.patient_not_found')); ?>', 'danger');
                });
        });
    }
});
</script>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/appointments/partials/form_scripts.blade.php ENDPATH**/ ?>