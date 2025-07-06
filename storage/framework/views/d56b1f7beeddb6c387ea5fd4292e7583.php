<?php $__env->startSection('title', 'Cotisations Management'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Manage Cotisations'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/style.css')); ?>">
<?php $__env->stopSection(); ?>

<?php
    $user = auth()->user();
    $isMember = $user->hasRole('member');
?>

<?php $__env->startSection('content'); ?>
    <?php if(session('toast') || session('success') || session('error')): ?>
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
            <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="<?php echo e(asset('favicon.svg')); ?>" class="img-fluid me-2" alt="favicon" style="width: 17px">
                    <strong class="me-auto">MonAsso</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <?php echo e(session('toast') ?? session('success') ?? session('error')); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card table-card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0"><?php echo e($isMember ? 'My Cotisations' : 'Cotisations List'); ?></h5>
                    <?php if(!$isMember && $user->hasAnyRole(['admin', 'superadmin', 'board'])): ?>
                        <a href="<?php echo e(route('admin.cotisations.create')); ?>" class="btn btn-primary">Add Cotisation</a>
                    <?php endif; ?>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <?php if (! ($isMember)): ?><th>User</th><?php endif; ?>
                                    <th>Year</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Paid At</th>
                                    <th>Receipt</th>
                                    <?php if (! ($isMember)): ?>
                                        <?php if($user->hasAnyRole(['admin', 'superadmin', 'board'])): ?>
                                        <th>Actions</th>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $cotisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cotisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <?php if (! ($isMember)): ?><td><?php echo e($cotisation->user->name ?? '—'); ?></td><?php endif; ?>
                                        <td><?php echo e($cotisation->year); ?></td>
                                        <td><?php echo e(number_format($cotisation->amount, 2)); ?> MAD</td>
                                        <td class="text-center fs-5">
                                            <?php if($cotisation->status == 1): ?>
                                                <span class="text-success">✔</span>
                                            <?php elseif($cotisation->status == 0): ?>
                                                <span class="text-warning">●</span>
                                            <?php elseif($cotisation->status == 2): ?>
                                                <span class="text-danger">⚠</span>
                                            <?php elseif($cotisation->status == 3): ?>
                                                <span class="text-secondary">✖</span>
                                            <?php else: ?>
                                                <span class="text-muted">?</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(optional($cotisation->paid_at)->format('Y-m-d H:i') ?? '—'); ?></td>
                                        <td><?php echo e($cotisation->receipt_number ?? '—'); ?></td>
                                        <?php if (! ($isMember)): ?>
                                            <?php if($user->hasAnyRole(['admin', 'superadmin', 'board'])): ?>
                                                <td>
                                                    <?php if($user->hasAnyRole(['admin', 'superadmin', 'board']) && ($user->hasRole('superadmin') || (int)$cotisation->association_id === (int)$user->association_id)): ?>
                                                    <a href="<?php echo e(route('admin.cotisations.edit', $cotisation)); ?>"
                                                        class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                                        <i class="ti ti-edit f-20"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                    <?php if($user->hasAnyRole(['admin', 'superadmin']) && ($user->hasRole('superadmin') || (int)$cotisation->association_id === (int)$user->association_id)): ?>
                                                    <form action="<?php echo e(route('admin.cotisations.destroy', $cotisation)); ?>" method="POST"
                                                        style="display:inline-block;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                            onclick="return confirm('Delete this cotisation?')" title="Delete">
                                                            <i class="ti ti-trash f-20"></i>
                                                        </button>
                                                    </form>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="<?php echo e($isMember ? 6 : 7); ?>" class="text-center text-muted">No cotisations found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script type="module">
        import { DataTable } from "/build/js/plugins/module.js";
        window.dt = new DataTable("#pc-dt-simple");
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toastEl = document.getElementById('liveToast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\cotisations\index.blade.php ENDPATH**/ ?>