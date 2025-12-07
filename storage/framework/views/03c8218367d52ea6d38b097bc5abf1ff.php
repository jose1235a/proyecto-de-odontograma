<!DOCTYPE html>
<html lang="en" style="height: auto;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__('global.app_name')); ?> - <?php echo $__env->yieldContent('title'); ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/fontawesome-free/css/all.min.css')); ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('adminlte/css/adminlte.min.css')); ?>">
    <!-- Custom Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('adminlte/css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('adminlte/css/custom_dark-mode.css')); ?>">
    <!-- Page Styles -->
    <?php echo $__env->yieldContent('styles'); ?>
    <!-- Stack Styles -->
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed text-md">
    <!-- wrapper -->
    <div class="wrapper">
        <!-- navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light text-md">
            <!-- Left navbar links -->
            <?php echo $__env->make('layouts.partials.app_navbar_left', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <!-- Right navbar links -->
            <?php echo $__env->make('layouts.partials.app_navbar_right', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-maroon elevation-4" style="background-color:#2c3e50 !important">
            <!-- Brand Logo -->
            <a href="<?php echo e(url('/')); ?>" class="brand-link">
                <img src="<?php echo e(asset('adminlte/img/AdminLTELogo.png')); ?>" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity:.8">
                <span class="brand-text font-weight-light"><?php echo e(__('global.app_name')); ?></span>
            </a>

            <!-- sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <?php if(auth()->guard()->check()): ?>
                            <?php
                                $photo = auth()->user()->photo;
                                $isExternal = Str::startsWith($photo, ['http://', 'https://']);
                            ?>

                            <img src="<?php echo e($isExternal ? $photo : asset('storage/' . $photo)); ?>"
                                class="img-circle elevation-2" alt="User" width="100">
                        <?php else: ?>
                            <img src="<?php echo e(asset('adminlte/img/user2-160x160.jpg')); ?>" class="img-circle elevation-2"
                                alt="Guest" width="100">
                        <?php endif; ?>
                    </div>
                    <div class="info">
                        <a class="d-block"><?php echo e(auth()->user()->name); ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <?php echo $__env->make('layouts.partials.app_sidebar_left', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- /.Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1024px;">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?php echo $__env->yieldContent('title'); ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(null, '/')); ?>">
                                        <?php echo e(__('global.home')); ?>

                                    </a>
                                </li>
                                <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title_navbar'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer text-md">
            <?php echo $__env->make('layouts.partials.app_footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </footer>
        <!-- /.Main Footer -->

        <!-- Control Right Sidebar -->
        <aside class="control-sidebar control-sidebar-dark" style="display:none;">
            <div class="p-3 control-sidebar-content">
                <?php echo $__env->make('layouts.partials.app_sidebar_right', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </aside>
        <!-- /.Control Right Sidebar -->

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?php echo e(asset('adminlte/plugins/jquery/jquery.min.js')); ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo e(asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo e(asset('adminlte/js/adminlte.min.js')); ?>"></script>
    <!-- Custom Scripts -->
    <script src="<?php echo e(asset('adminlte/js/custom.js')); ?>"></script>
    <script src="<?php echo e(asset('adminlte/js/custom_dark-mode.js')); ?>"></script>
    <!-- Sweetalert2 -->
    <?php echo $__env->make('layouts.plugins.sweetalert2', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Parsley -->
    <?php echo $__env->make('layouts.plugins.parsley', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Page Scripts -->
    <?php echo $__env->yieldContent('scripts'); ?>
    <!-- Stack Scripts -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/layouts/app.blade.php ENDPATH**/ ?>