<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <!-- =========================
         AUTH MANAGEMENT
    ========================== -->
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['roles.view', 'users.view'])): ?>
    <li class="nav-header"><?php echo e(__('sidebar.title_auth_management')); ?></li>

    <li class="nav-item <?php echo e(menuOpenClass(['auth_management/roles*', 'auth_management/users*'])); ?>">
        <a href="#" class="nav-link <?php echo e(activeClass(['auth_management/roles*', 'auth_management/users*'])); ?>">
            <i class="nav-icon fas fa-shield-alt"></i>
            <p>
                <?php echo e(__('sidebar.menu_auth_management')); ?>

                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('auth_management.roles.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['auth_management/roles*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('roles.title')); ?></p>
                </a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('auth_management.users.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['auth_management/users*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('sidebar.users')); ?></p>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </li>
    <?php endif; ?>

    <!-- =========================
         SETTINGS
    ========================== -->
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['system_modules.view', 'languages.view', 'tenants.view', 'regions.view'])): ?>
    <li class="nav-header"><?php echo e(__('sidebar.title_setting')); ?></li>

    <li class="nav-item <?php echo e(menuOpenClass(['system_management/languages*','system_management/system_modules*','system_management/tenants*','system_management/regions*'])); ?>">
        <a href="#" class="nav-link <?php echo e(activeClass(['system_management/languages*','system_management/system_modules*','system_management/tenants*','system_management/regions*'])); ?>">
            <i class="nav-icon fas fa-cog"></i>
            <p>
                <?php echo e(__('sidebar.menu_settings')); ?>

                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system_modules.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('system_management.system_modules.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['system_management/system_modules*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('system_modules.plural')); ?></p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('languages.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('system_management.languages.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['system_management/languages*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('languages.plural')); ?></p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tenants.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('system_management.tenants.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['system_management/tenants*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('tenants.plural')); ?></p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('regions.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('system_management.regions.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['system_management/regions*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('regions.plural')); ?></p>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </li>
    <?php endif; ?>

    <!-- =========================
         DENTAL MANAGEMENT
    ========================== -->
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['patients.view', 'specialties.view', 'doctors.view', 'treatments.view', 'appointments.view', 'calendar.view', 'payments.view'])): ?>
    <li class="nav-header"><?php echo e(__('sidebar.title_dental_management')); ?></li>
    <?php
        $patientContext = returnUrlMatches(['dental_management/patients*']);
    ?>

    <li class="nav-item <?php echo e(menuOpenClass(['dental_management/*'], true)); ?>">
        <a href="#" class="nav-link <?php echo e(activeClass(['dental_management/*'], true)); ?>">
            <i class="nav-icon fas fa-tooth"></i>
            <p>
                <?php echo e(__('sidebar.menu_dental_management')); ?>

                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('dental_management.patients.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['dental_management/patients*', 'dental_management/patient_images*', 'dental_management/consultations*', 'dental_management/odontogram*', 'dental_management/appointment_history*'], true)); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('dental_management.patients.title')); ?></p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('specialties.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('dental_management.specialties.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['dental_management/specialties*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('dental_management.specialties.title')); ?></p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('doctors.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('dental_management.doctors.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['dental_management/doctors*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('dental_management.doctors.title')); ?></p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('treatments.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('dental_management.treatments.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['dental_management/treatments*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('dental_management.treatments.title')); ?></p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('appointments.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('dental_management.appointments.index')); ?>"
                   class="nav-link <?php echo e($patientContext ? '' : activeClass(['dental_management/appointments*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('dental_management.appointments.title')); ?></p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('calendar.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('dental_management.calendar.index')); ?>"
                   class="nav-link <?php echo e(activeClass(['dental_management/calendar*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('dental_management.calendar.title')); ?></p>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payments.view')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('dental_management.payments.index')); ?>"
                   class="nav-link <?php echo e($patientContext ? '' : activeClass(['dental_management/payments*'])); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo e(__('dental_management.payments.title')); ?></p>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </li>
    <?php endif; ?>
</ul>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/layouts/partials/app_sidebar_left.blade.php ENDPATH**/ ?>