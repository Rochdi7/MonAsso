<?php $__env->startSection('title', 'Associations Management'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Manage Associations'); ?>

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
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h5 class="mb-3 mb-sm-0">Associations List</h5>
                        <div>
                            <a href="<?php echo e(route('admin.associations.create')); ?>" class="btn btn-primary">Add Association</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Validated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $associations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $association): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                        <?php
    $media = $association->getFirstMedia('logos');
?>

<?php if($media): ?>
    <img src="<?php echo e(route('media.custom', ['id' => $media->id, 'filename' => $media->file_name])); ?>"
         alt="logo"
         width="40"
         height="40"
         class="rounded shadow-sm">
<?php else: ?>
    <span class="text-muted">N/A</span>
<?php endif; ?>

                                        </td>
                                        <td><?php echo e($association->name); ?></td>
                                        <td><?php echo e($association->email); ?></td>
                                        <td>
                                            <?php
                                                $status = $association->announcement_status;
                                            ?>
                                            <?php if($status === 'active'): ?>
                                                <span class="badge bg-light-success text-success">✔ Active</span>
                                            <?php elseif($status === 'pending'): ?>
                                                <span class="badge bg-light-warning text-warning">⏳ Pending</span>
                                            <?php elseif($status === 'suspended'): ?>
                                                <span class="badge bg-light-danger text-danger">⛔ Suspended</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($association->creation_date ?? 'N/A'); ?></td>
                                        <td>
                                            <?php if($association->is_validated): ?>
                                                <span class="badge bg-light-success text-success"
                                                    title="Validated on <?php echo e($association->validation_date); ?>">
                                                    <?php echo e($association->validation_date); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-light-danger text-danger" title="Not Validated">
                                                    Not Validated
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <a href="<?php echo e(route('admin.associations.edit', $association)); ?>"
                                                class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.associations.destroy', $association)); ?>" method="POST"
                                                style="display:inline-block;">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                    onclick="return confirm('Delete this association?')" title="Delete">
                                                    <i class="ti ti-trash f-20"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No associations found.</td>
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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/admin/associations/index.blade.php ENDPATH**/ ?>