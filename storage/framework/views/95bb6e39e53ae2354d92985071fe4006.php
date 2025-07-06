<?php $__env->startSection('title', 'Membres Management'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Manage Membres'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/style.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(session()->has('toast') || session()->has('success') || session()->has('error')): ?>
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
                    <h5 class="mb-3 mb-sm-0">Membres List</h5>
                    <a href="<?php echo e(route('admin.membres.create')); ?>" class="btn btn-primary">Add Membre</a>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Association</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <?php if($user->getFirstMediaUrl('profile_photo')): ?>
                                                <img src="<?php echo e($user->getFirstMediaUrl('profile_photo')); ?>" alt="photo" width="40"
                                                    height="40" class="rounded-circle shadow-sm">
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->phone ?? '-'); ?></td>
                                        <td><span
                                                class="badge bg-secondary text-uppercase"><?php echo e($user->getRoleNames()->first() ?? 'N/A'); ?></span>
                                        </td>
                                        <td><?php echo $user->is_active ? '<span class="text-success">✔ Active</span>' : '<span class="text-danger">✘ Inactive</span>'; ?>

                                        </td>
                                        <td><?php echo e($user->association?->name ?? 'N/A'); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.membres.show', $user->id)); ?>"
                                                class="avtar avtar-xs btn-link-secondary" title="View">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.membres.edit', $user->id)); ?>"
                                                class="avtar avtar-xs btn-link-secondary" title="Edit">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <?php $authUser = auth()->user(); ?>

                                            <?php if(!$authUser->hasRole('board')): ?>
                                                <form action="<?php echo e(route('admin.membres.destroy', $user->id)); ?>" method="POST"
                                                    onsubmit="return confirm('Delete this user?')" style="display:inline;">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                        class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                        title="Delete">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No users found.</td>
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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\membres\index.blade.php ENDPATH**/ ?>