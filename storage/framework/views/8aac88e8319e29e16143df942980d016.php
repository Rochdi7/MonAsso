<?php $__env->startSection('title', 'Meeting Details'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Meeting Documents'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/style.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Meeting Details</h5>
                <a href="<?php echo e(route('admin.meetings.index')); ?>" class="btn btn-sm btn-outline-dark">← Back to List</a>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5><?php echo e($meeting->title); ?></h5>
                    <p class="mb-1"><strong>Organizer:</strong> <?php echo e($meeting->organizer->name ?? 'N/A'); ?></p>
                    <p class="mb-1"><strong>Date & Time:</strong> <?php echo e(\Carbon\Carbon::parse($meeting->datetime)->format('Y-m-d H:i')); ?></p>
                    <p class="mb-3">
                        <strong>Status:</strong>
                        <?php if($meeting->status === 1): ?>
                            <span class="badge bg-light-success text-success">✔ Confirmed</span>
                        <?php elseif($meeting->status === 2): ?>
                            <span class="badge bg-light-danger text-danger">✖ Cancelled</span>
                        <?php else: ?>
                            <span class="badge bg-light-warning text-warning">⏳ Pending</span>
                        <?php endif; ?>
                    </p>
                </div>

                <hr>

                <h6>Attached Documents</h6>
                <?php if($documents->isEmpty()): ?>
                    <p class="text-muted">No documents found for this meeting.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    📎 <?php echo e($doc->file_name); ?>

                                </span>
                                <a href="<?php echo e(route('media.custom', ['id' => $doc->id, 'filename' => rawurlencode($doc->file_name)])); ?>"
                                   class="btn btn-sm btn-primary" target="_blank">
                                    View / Download
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\meetings\show.blade.php ENDPATH**/ ?>