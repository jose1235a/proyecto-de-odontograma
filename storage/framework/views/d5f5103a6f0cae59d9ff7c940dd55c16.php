
<link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')); ?>">
<script src="<?php echo e(asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>


<script>
  $(function() {
    var Toast = Swal.mixin({
      toast: false,
      timerProgressBar: true          // Display a progress bar
    });
    
    // Session success   
    <?php if(session('success')): ?>
      Toast.fire({
        icon: 'success',
        title: '<?php echo e(__('global.success')); ?>',
        text: '<?php echo e(session('success')); ?>',
        showConfirmButton: false,
        timer: 3000
      });
    <?php endif; ?>
    
    // Session error   
    <?php if(session('error')): ?>
      Toast.fire({
        icon: 'error',
        title: '<?php echo e(__('global.error')); ?>',
        text: '<?php echo e(session('error')); ?>',
        showConfirmButton: false,
        timer: 3000
      });
    <?php endif; ?>

    // Display error validations       
    <?php if($errors->any()): ?>
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '<?php echo e($errors->first()); ?>',
        showConfirmButton: false,      
        timer: 3000 
      });
    <?php endif; ?>
  });

  // Función para confirmación de eliminación
  function confirmDelete() {
    Swal.fire({
      title: "<?php echo e(__('global.are_you_sure')); ?>",
      text: "<?php echo e(__('global.warning_delete')); ?>",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: "<?php echo e(__('global.destroy')); ?>",
      cancelButtonText: "<?php echo e(__('global.cancel')); ?>"
    }).then((result) => {
      if (result.isConfirmed) {
        if ($('#form-save').parsley().validate()) {
          document.getElementById('form-save').submit();
        }
      }
    });
  }
</script>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/layouts/plugins/sweetalert2.blade.php ENDPATH**/ ?>