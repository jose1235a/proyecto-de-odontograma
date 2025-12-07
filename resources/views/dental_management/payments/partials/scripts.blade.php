<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '{{ __("global.select_option") }}',
        width: '100%',
        dropdownParent: $('.modal-body, .card-body, body').first(),
        dropdownAutoWidth: true
    });

    // Handle patient change to load appointments
    let patientChanged = false;
    $('#patient_id').on('change', function() {
        const patientId = $(this).val();
        const appointmentSelect = $('#appointment_id');

        if (patientId) {
            // Show loading
            appointmentSelect.html('<option value="">Buscando citas...</option>');
            appointmentSelect.prop('disabled', true);

            // Fetch appointments for this patient
            fetch(`{{ url('dental_management/payments/search_patient_appointments') }}?patient_id=${patientId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">Seleccionar cita</option>';
                if (data.appointments && data.appointments.length > 0) {
                    data.appointments.forEach(appointment => {
                        const date = new Date(appointment.appointment_date).toLocaleDateString('es-ES');
                        const time = appointment.appointment_time ? appointment.appointment_time.substring(0, 5) : 'N/A';
                        const treatment = appointment.treatment ? appointment.treatment.name : 'Sin tratamiento';
                        // Only pre-select if it's the first load and we have initialAppointmentId
                        const selected = !patientChanged && initialAppointmentId && initialAppointmentId == appointment.id ? 'selected' : '';
                        options += `<option value="${appointment.id}" ${selected}>${date} ${time} - ${treatment}</option>`;
                    });
                }
                appointmentSelect.html(options);
                appointmentSelect.prop('disabled', false);
                appointmentSelect.trigger('change');
                patientChanged = true; // Mark that patient has been changed
            })
            .catch(error => {
                console.error('Error loading appointments:', error);
                appointmentSelect.html('<option value="">Error al cargar citas</option>');
                appointmentSelect.prop('disabled', false);
            });
        } else {
            appointmentSelect.html('<option value="">Seleccionar cita</option>');
            appointmentSelect.prop('disabled', false);
            patientChanged = true;
        }
    });

    // Trigger change on page load if patient is pre-selected
    if ($('#patient_id').val()) {
        $('#patient_id').trigger('change');
    }

    // Store initial appointment selection
    const initialAppointmentId = $('#appointment_id').val();
});
</script>

<style>
/* Ensure Select2 dropdown opens downward */
.select2-container--bootstrap4 .select2-dropdown {
    border-color: #ced4da;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.select2-container--bootstrap4 .select2-results__option--highlighted {
    background-color: #007bff;
    color: white;
}

.select2-container--bootstrap4 .select2-selection__clear {
    color: #6c757d;
    cursor: pointer;
    float: right;
    font-weight: bold;
    margin-right: 30px;
}
</style>