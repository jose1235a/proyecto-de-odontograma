<?php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'desc');
    $sortUrl = function (string $column, string $defaultDirection = 'asc') use ($currentSort, $currentDirection) {
        $direction = $currentSort === $column
            ? ($currentDirection === 'asc' ? 'desc' : 'asc')
            : $defaultDirection;
        return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $direction, 'page' => 1]);
    };
?>

<table class="table table-hover">
    <thead class="bg-light">
        <tr>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('id')); ?>">N°</a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('created_at', 'desc')); ?>"><?php echo e(__('dental_management.payments.payment_date')); ?></a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('patient')); ?>"><?php echo e(__('dental_management.payments.patient')); ?></a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('amount', 'desc')); ?>"><?php echo e(__('dental_management.payments.amount')); ?></a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('payment_method')); ?>"><?php echo e(__('dental_management.payments.fields.payment_method')); ?></a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('status')); ?>"><?php echo e(__('dental_management.payments.fields.status')); ?></a>
            </th>
            <th>
                <a class="text-dark text-decoration-none" href="<?php echo e($sortUrl('reference_number')); ?>"><?php echo e(__('dental_management.payments.fields.reference_number')); ?></a>
            </th>
            <th><?php echo e(__('global.actions')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration + ($payments->currentPage() - 1) * $payments->perPage()); ?></td>
                <td><?php echo e($payment->created_at->format('d/m/Y H:i')); ?></td>
                <td><?php echo e($payment->patient->name ?? '-'); ?></td>
                <td><strong><?php echo e($payment->amount_formatted); ?></strong></td>
                <td><?php echo $payment->payment_method_html; ?></td>
                <td><?php echo $payment->status_html; ?></td>
                <td><?php echo e($payment->reference_number ?? '-'); ?></td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payments.view')): ?>
                        <a class="btn btn-light" href="<?php echo e(route('dental_management.payments.show', $payment->slug)); ?>?return_url=<?php echo e(urlencode(request()->fullUrl())); ?>" title="<?php echo e(__('global.show')); ?>">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payments.edit')): ?>
                        <a class="btn btn-light" href="<?php echo e(route('dental_management.payments.edit', $payment->slug)); ?>?return_url=<?php echo e(urlencode(request()->fullUrl())); ?>" title="<?php echo e(__('global.edit')); ?>">
                            <i class="fas fa-pen"></i>
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payments.delete')): ?>
                        <a class="btn btn-light" href="<?php echo e(route('dental_management.payments.delete', $payment->slug)); ?>?return_url=<?php echo e(urlencode(request()->fullUrl())); ?>" title="<?php echo e(__('global.delete')); ?>">
                            <i class="fas fa-trash"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" class="text-center"><?php echo e(__('global.no_records')); ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php if($payments->hasPages()): ?>
    <div class="d-flex justify-content-center mt-3">
        <?php echo e($payments->appends(request()->query())->links()); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\blog_main_base\resources\views/dental_management/payments/partials/index_results.blade.php ENDPATH**/ ?>