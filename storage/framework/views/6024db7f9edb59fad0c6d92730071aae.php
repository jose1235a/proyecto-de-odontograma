<?php $__env->startSection('title', __('dental_management.doctors.create_title')); ?>
<?php $__env->startSection('title_navbar', __('dental_management.doctors.plural')); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-info rounded">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-plus"></i> <?php echo e(__('dental_management.doctors.create')); ?>

        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="<?php echo e(__('global.collapse')); ?>">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <?php echo $__env->make('dental_management.doctors.partials.form_create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      </div>
      <div class="card-footer text-center">
        <button type="submit" form="form-save" class="btn btn-primary mr-4">
          <i class="fas fa-save"></i> <?php echo e(__('global.save')); ?>

        </button>
        <a href="<?php echo e(route('dental_management.doctors.index')); ?>" class="btn btn-default">
          <i class="fas fa-arrow-left"></i> <?php echo e(__('global.back')); ?>

        </a>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('dental_management.doctors.partials.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
$(document).ready(function() {
    $('#document').on('blur', function() {
        if ($('#document_type').val() === 'dni') {
            var dni = $(this).val().trim();
            if (dni.length === 8 && /^\d+$/.test(dni)) {
                $.ajax({
                    url: '<?php echo e(route("dental_management.doctors.dni.lookup")); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        dni: dni
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#name').val(response.name);
                            $('#last_name').val(response.last_name);
                        } else {
                            console.log(response.message || 'No se encontraron datos.');
                        }
                    },
                    error: function() {
                        console.log('Error al consultar el DNI.');
                    }
                });
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/doctors/create.blade.php ENDPATH**/ ?>