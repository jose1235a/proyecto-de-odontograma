<!-- DataTables -->
<script src="<?php echo e(asset('adminlte/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">

<!-- Select2 -->
<script src="<?php echo e(asset('adminlte/plugins/select2/js/select2.full.min.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/select2/css/select2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">

<script>
$(document).ready(function() {
    $('.table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });

    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: '<?php echo e(__("global.select_option")); ?>',
        allowClear: true,
        width: '100%'
    });

    // Re-initialize specialties with multiselect options
    $('#specialties').select2('destroy').select2({
        theme: 'bootstrap4',
        placeholder: '<?php echo e(__("global.select_option")); ?>',
        allowClear: true,
        width: '100%',
        closeOnSelect: false
    });
});
</script><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/doctors/partials/scripts.blade.php ENDPATH**/ ?>