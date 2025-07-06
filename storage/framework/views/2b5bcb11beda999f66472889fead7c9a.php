<?php $__env->startSection('title', 'Member Profile'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'User Card'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
  <div class="col-md-8 col-xl-6">
    <div class="card user-card">
      <div class="card-body">

        <!-- User Cover -->
        <div class="user-cover-bg">
          <img src="<?php echo e(URL::asset('build/images/application/img-user-cover-1.jpg')); ?>" alt="cover" class="img-fluid" />
          <div class="cover-data">
            <div class="d-inline-flex align-items-center">
              <i class="ph-duotone ph-star text-warning me-1"></i>
              <?php echo e(strtoupper($user->getRoleNames()->first() ?? 'N/A')); ?>

            </div>
          </div>
        </div>

        <!-- Avatar -->
        <div class="chat-avtar card-user-image">
          <?php if($user->getFirstMediaUrl('profile_photo')): ?>
            <img src="<?php echo e($user->getFirstMediaUrl('profile_photo')); ?>" alt="photo" class="img-thumbnail rounded-circle" />
          <?php else: ?>
            <img src="<?php echo e(asset('build/images/user/avatar-1.jpg')); ?>" alt="photo" class="img-thumbnail rounded-circle" />
          <?php endif; ?>
          <i class="chat-badge <?php echo e($user->is_active ? 'bg-success' : 'bg-danger'); ?>"></i>
        </div>

        <!-- Name + Info -->
        <div class="d-flex">
          <div class="flex-grow-1 ms-2 text-center">
            <h5 class="mb-1"><?php echo e($user->name); ?></h5>
            <p class="text-muted text-sm mb-0"><?php echo e($user->email); ?></p>
            <p class="text-muted text-sm mb-0">📞 <?php echo e($user->phone ?? '-'); ?></p>
            <p class="text-muted text-sm mb-0"><strong>Association:</strong> <?php echo e($user->association?->name ?? 'N/A'); ?></p>
          </div>
        </div>

        <!-- Extra Actions -->
        <div class="saprator my-2"><span>Actions</span></div>
        <div class="d-flex justify-content-center gap-2">
    <a href="<?php echo e(route('admin.cotisations.create', ['user_id' => $user->id])); ?>" class="btn btn-outline-primary">
        ➕ Add Cotisation
    </a>
    <a href="<?php echo e(route('admin.membres.edit', $user->id)); ?>" class="btn btn-outline-secondary">
        ✎ Edit
    </a>
    <a href="<?php echo e(route('admin.membres.index')); ?>" class="btn btn-outline-dark">
        ← Back to List
    </a>
</div>


      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\membres\profiles.blade.php ENDPATH**/ ?>