$(document).ready(function() {
    // Initialize DataTable
    $('#specialties-table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "emptyTable": "{{ __('global.no_records') }}",
            "zeroRecords": "{{ __('global.no_records') }}"
        }
    });

    // Initialize Parsley validation
    $('form').parsley({
        errorClass: 'is-invalid',
        successClass: 'is-valid',
        errorsWrapper: '<span class="invalid-feedback"></span>',
        errorTemplate: '<span></span>',
        trigger: 'blur'
    });
});

// Submit form with Parsley validation
function submitWithParsley() {
    var form = $('form');
    form.parsley().validate();

    if (form.parsley().isValid()) {
        form.submit();
    }
}