<?php $__env->startSection('title', __('auth.login')); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-lg">
  <div class="row no-gutters">
    <div class="col-12 text-center bg-info text-white py-3" >
      <b><?php echo e(config('app.name')); ?></b>
    </div>

    
    <div class="col-md-8 p-4">
      <div class="text-center mb-3">
        <a class="h1 text-dark"><b><?php echo e(__('global.app_name')); ?></b></a>
      </div>

      <form id="form-save" action="<?php echo e(route('login.post')); ?>" method="POST" autocomplete="off" data-parsley-validate>
        <?php echo csrf_field(); ?>
        
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" data-parsley-errors-container="#email-error" placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('users.email')])); ?>" required data-parsley-type="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div id="email-error"></div>

        
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" data-parsley-errors-container="#password-error" placeholder="<?php echo e(__('global.placeholders.complete_attribute', ['attribute' => __('users.password')])); ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div id="password-error"></div>

        
        <div class="row">
          <div class="col-6">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember"> <?php echo e(__('auth.rememberme')); ?> </label>
            </div>
          </div>
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block btn_submit"><i class="fas fa-sign-in-alt"></i>  <?php echo e(__('auth.login')); ?></button>
          </div>
        </div>
      </form>

      <div class="social-auth-links text-center mt-3 mb-2">
        <a href="<?php echo e(route('auth_management.google.redirect')); ?>" class="btn btn-block btn-secondary">
          <i class="fab fa-google mr-2"></i> <?php echo e(__('auth.login_google')); ?>

        </a>
      </div>

      <p class="mb-1 text-center pt-2">
        <a href="<?php echo e(route('password.request')); ?>"><?php echo e(__('auth.forgot_password')); ?></a>
      </p>      

      <p class="text-center text-sm mt-3">
        <?php echo __('global.disclosure', [
          'terms' => '<a href="' . route('legal_management.terms') . '" target="_blank">' . __('global.terms') . '</a>',
          'privacy' => '<a href="' . route('legal_management.privacy') . '" target="_blank">' . __('global.privacy') . '</a>',
        ]); ?>

      </p>
    </div>

    
    <div class="col-md-4 d-none d-md-block">
      <img id="login-avatar"
          src="<?php echo e(asset('adminlte/img/login_avatar.gif')); ?>"
          data-default="<?php echo e(asset('adminlte/img/login_avatar.gif')); ?>"
          data-email="<?php echo e(asset('adminlte/img/login_avatar_email.png')); ?>"
          data-pass="<?php echo e(asset('adminlte/img/login_avatar_password.png')); ?>"
          alt="Login Image"
          class="img-fluid h-100 w-100"
          style="object-fit: cover; border-top-right-radius: .25rem; border-bottom-right-radius: .25rem;">
    </div>

  </div>
  <div class="card-footer small text-muted py-1">
    <p class="mb-0 text-start" style="font-size: 0.65rem;">
      <?php echo e(__('auth.disclaimer_affiliation', ['app' => config('app.name')])); ?>

    </p>

    <p class="mb-0 text-start" style="font-size: 0.65rem;">
      <?php echo e(__('auth.client_content_responsibility')); ?>

    </p>

    <p class="mb-0 text-center">
      © <?php echo e(now()->year); ?> <?php echo e(config('app.name')); ?> – <?php echo e(__('auth.all_rights_reserved')); ?>

    </p>    
  </div>
</div>


<div class="text-center my-2">
  <select onchange="location = this.value;" class="form-select form-select-sm w-auto d-inline-block">
    <option value="<?php echo e(LaravelLocalization::getLocalizedURL('es', null, [], true)); ?>" <?php echo e(app()->getLocale() == 'es' ? 'selected' : ''); ?>>Español</option>
    <option value="<?php echo e(LaravelLocalization::getLocalizedURL('en', null, [], true)); ?>" <?php echo e(app()->getLocale() == 'en' ? 'selected' : ''); ?>>English</option>
    <option value="<?php echo e(LaravelLocalization::getLocalizedURL('pt', null, [], true)); ?>" <?php echo e(app()->getLocale() == 'pt' ? 'selected' : ''); ?>>Português</option>
  </select>
</div>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.login', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\blog_main_base\resources\views/auth_management/auth/login.blade.php ENDPATH**/ ?>