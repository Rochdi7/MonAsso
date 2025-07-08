<?php $__env->startSection('title', 'Expenses Management'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Manage Expenses'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/style.css')); ?>">
<?php $__env->stopSection(); ?>

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
                <h5 class="mb-3 mb-sm-0">Expenses List</h5>
                <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'admin|superadmin|board')): ?>
                <a href="<?php echo e(route('admin.expenses.create')); ?>" class="btn btn-primary">Add Expense</a>
                <?php endif; ?>
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Spent At</th>
                                <th>Association</th>
                                <th>Description</th>
                                <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'admin|superadmin|board')): ?>
                                <th>Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($expense->title); ?></td>
                                <td><?php echo e(number_format($expense->amount, 2)); ?> MAD</td>
                                <td><?php echo e(optional($expense->spent_at)->format('Y-m-d') ?? '—'); ?></td>
                                <td><?php echo e($expense->association->name ?? '—'); ?></td>
                                <td><?php echo e($expense->description ?? '—'); ?></td>
                                <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'admin|superadmin|board')): ?>
                                <td>
                                    <?php if(auth()->user()->hasAnyRole(['admin', 'superadmin', 'board']) && (auth()->user()->hasRole('superadmin') || auth()->user()->association_id === $expense->association_id)): ?>
                                    <a href="<?php echo e(route('admin.expenses.edit', $expense)); ?>"
                                        class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                        <i class="ti ti-edit f-20"></i>
                                    </a>
                                    <?php endif; ?>

                                    <?php if(auth()->user()->hasAnyRole(['admin', 'superadmin']) && (auth()->user()->hasRole('superadmin') || auth()->user()->association_id === $expense->association_id)): ?>
                                    <form action="<?php echo e(route('admin.expenses.destroy', $expense)); ?>" method="POST"
                                        style="display:inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                            onclick="return confirm('Delete this expense?')" title="Delete">
                                            <i class="ti ti-trash f-20"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No expenses found.</td>
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

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/admin/expenses/index.blade.php ENDPATH**/ ?>