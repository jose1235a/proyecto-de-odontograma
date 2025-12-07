
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(__('global.app_name')); ?> - <?php echo $__env->yieldContent('title'); ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/fontawesome-free/css/all.min.css')); ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('adminlte/css/adminlte.min.css')); ?>">
    <!-- Custom Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('adminlte/css/custom.css')); ?>">     
    <!-- Custom Scripts --> 
    <script src="<?php echo e(asset('adminlte/js/custom.js')); ?>"></script>
  </head>
  <body class="login-page">
    <div class="container">
      <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-10 col-lg-8">
          <?php echo $__env->yieldContent('content'); ?>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo e(asset('adminlte/plugins/jquery/jquery.min.js')); ?>"></script>

    <!-- Bootstrap 4 -->
    <script src="<?php echo e(asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>

    <!-- AdminLTE App -->
    <script src="<?php echo e(asset('adminlte/js/adminlte.min.js')); ?>"></script>

    <!-- SweetAlert2 Login-->
    <?php echo $__env->make('layouts.plugins.sweetalert2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Parsley -->
    <?php echo $__env->make('layouts.plugins.parsley', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
  </body>
</html><?php /**PATH C:\laragon\www\blog_main_base\resources\views/layouts/login.blade.php ENDPATH**/ ?>