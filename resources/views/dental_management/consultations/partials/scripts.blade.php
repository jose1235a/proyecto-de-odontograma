<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '{{ __("global.select_option") }}',
        width: '100%',
        dropdownParent: $('.modal-body, .card-body, body').first(),
        dropdownAutoWidth: true
    });

    // Initialize any plugins if needed
    console.log('Consultations scripts loaded');
});
</script>