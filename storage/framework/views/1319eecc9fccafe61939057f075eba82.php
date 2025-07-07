<?php $__env->startSection('title', 'Member Profile'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'User Card'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/style.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <!-- Left: User Card -->
        <div class="col-md-5">
            <div class="card user-card shadow-sm">
                <div class="card-body">
                    <!-- User Cover -->
                    <div class="user-cover-bg rounded">
                        <img src="<?php echo e(URL::asset('build/images/application/img-user-cover-1.jpg')); ?>" alt="cover"
                            class="img-fluid rounded" />
                        <div class="cover-data">
                            <div class="d-inline-flex align-items-center">
                                <i class="ph-duotone ph-star text-warning me-1"></i>
                                <?php echo e(strtoupper($user->getRoleNames()->first() ?? 'N/A')); ?>

                            </div>
                        </div>
                    </div>

                    <!-- Avatar -->
                    <div class="chat-avtar card-user-image">
                        <?php
                            $authUser = Auth::user();
                            $media = $authUser->getFirstMedia('profile_photo');
                            $avatar = $media
                                ? route('media.custom', ['id' => $media->id, 'filename' => $media->file_name])
                                : asset('build/images/user/avatar-1.jpg');
                        ?>

                        <img src="<?php echo e($avatar); ?>" alt="photo" class="rounded-circle" width="40" height="40">

                        <i class="chat-badge <?php echo e($user->is_active ? 'bg-success' : 'bg-danger'); ?>"></i>
                    </div>

                    <!-- User Info -->
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1 ms-2 text-center">
                            <h5 class="mb-1"><?php echo e($user->name); ?></h5>
                            <p class="text-muted text-sm mb-0"><?php echo e($user->email); ?></p>
                            <p class="text-muted text-sm mb-0">📞 <?php echo e($user->phone ?? '-'); ?></p>
                            <p class="text-muted text-sm mb-0">
                                <strong>Association:</strong> <?php echo e($user->association?->name ?? 'N/A'); ?>

                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?php echo e(route('admin.membres.edit', $user->id)); ?>" class="btn btn-primary btn-sm">Edit</a>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="saprator my-3"><span>Actions</span></div>
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('admin.cotisations.create', ['user_id' => $user->id])); ?>"
                            class="btn btn-outline-primary w-100">
                            <i data-feather="plus"></i> Add Cotisation
                        </a>
                        <a href="<?php echo e(route('admin.membres.index')); ?>" class="btn btn-outline-dark w-100">
                            ← Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Cotisation History Table -->
        <div class="col-md-7">
            <div class="card table-card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Cotisation History</h5>
                </div>

                <div class="card-body">
                    <?php if($cotisations->isEmpty()): ?>
                        <p class="text-muted">No cotisations found for this user.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="cotisation-history-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date/Time</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cotisations->sortByDesc('created_at')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $cotisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td>
                                                <?php echo e($cotisation->created_at->format('Y/m/d')); ?>

                                                <span
                                                    class="text-muted text-sm d-block"><?php echo e($cotisation->created_at->format('h:i A')); ?></span>
                                            </td>
                                            <td><?php echo e(number_format($cotisation->amount, 2)); ?> MAD</td>
                                            <td>
                                                <?php
                                                    $statusLabels = [
                                                        0 => ['label' => 'Pending', 'badge' => 'text-bg-warning'],
                                                        1 => ['label' => 'Paid', 'badge' => 'text-bg-success'],
                                                        2 => ['label' => 'Overdue', 'badge' => 'text-bg-danger'],
                                                        3 => ['label' => 'Rejected', 'badge' => 'text-bg-secondary'],
                                                    ];

                                                    $status = $statusLabels[$cotisation->status] ?? [
                                                        'label' => 'Unknown',
                                                        'badge' => 'text-bg-secondary',
                                                    ];
                                                ?>

                                                <span class="badge <?php echo e($status['badge']); ?>">
                                                    <?php echo e($status['label']); ?>

                                                </span>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(URL::asset('build/js/plugins/simple-datatables.js')); ?>"></script>
    <script>
        const dataTable = new simpleDatatables.DataTable('#cotisation-history-table', {
            perPage: 5,
            sortable: true
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\membres\show.blade.php ENDPATH**/ ?>