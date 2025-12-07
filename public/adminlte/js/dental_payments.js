// Dental Payments JavaScript
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '{{ __("global.select_option") }}',
        width: '100%',
        dropdownParent: $('.modal-body, .card-body, body').first(),
        dropdownAutoWidth: true
    });

    // Submit with Parsley validation
    window.submitWithParsley = function() {
        var form = document.getElementById('filter-form');
        if (form) {
            // Trigger Parsley validation
            if ($(form).parsley().validate()) {
                form.submit();
            }
        }
    };
});