<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '<?php echo e(__("global.select_option")); ?>',
        width: '100%',
        dropdownParent: $('.modal-body, .card-body, body').first(),
        dropdownAutoWidth: true
    });

    // Initialize any plugins if needed
    console.log('Consultations scripts loaded');
});
</script><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/consultations/partials/scripts.blade.php ENDPATH**/ ?>