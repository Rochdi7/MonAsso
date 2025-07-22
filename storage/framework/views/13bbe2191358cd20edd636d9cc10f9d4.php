<?php $__env->startSection('title', 'Create Cotisation'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'New Cotisation'); ?>
<?php $__env->startSection('page-animation', 'animate__rollIn'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/animate.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger animate__animated animate__shakeX">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.cotisations.store')); ?>" method="POST" class="needs-validation" novalidate>
            <?php echo csrf_field(); ?>

            <div id="cotisation-form-card" class="card animate__animated animate__rollIn">
                <div class="card-header">
                    <h5>New Cotisation Form</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <?php
                            $authUser = auth()->user();
                        ?>

                        
                        <?php if(isset($selectedUserId)): ?>
                            <input type="hidden" name="user_id" value="<?php echo e($selectedUserId); ?>">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">User</label>
                                <input type="text" class="form-control" value="<?php echo e($users->find($selectedUserId)?->name); ?>" disabled readonly>
                            </div>
                        <?php else: ?>
                            <div class="mb-3 col-md-6">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" class="form-select <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Select user...</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>" <?php if(old('user_id') == $user->id): echo 'selected'; endif; ?>>
                                            <?php echo e($user->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        <?php endif; ?>

                        
                        <?php if($authUser->hasRole('superadmin')): ?>
                            <div class="mb-3 col-md-6">
                                <label for="association_id" class="form-label">Association</label>
                                <select name="association_id" class="form-select <?php $__errorArgs = ['association_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Select association...</option>
                                    <?php $__currentLoopData = $associations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $association): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($association->id); ?>" <?php if(old('association_id') == $association->id): echo 'selected'; endif; ?>>
                                            <?php echo e($association->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['association_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="association_id" value="<?php echo e($authUser->association_id); ?>">
                        <?php endif; ?>

                        
                        <div class="mb-3 col-md-6">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" name="year" class="form-control <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('year', now()->year)); ?>" required>
                            <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3 col-md-6">
                            <label for="amount" class="form-label">Amount (MAD)</label>
                            <input type="number" step="0.01" name="amount" class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('amount')); ?>" required>
                            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
    <option value="">Select status...</option>
    <option value="1" <?php if(old('status') == '1'): echo 'selected'; endif; ?>>Paid</option>
    <option value="0" <?php if(old('status') == '0'): echo 'selected'; endif; ?>>Not Paid</option>
</select>

                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3 col-md-6">
                            <label for="paid_at" class="form-label">Paid At</label>
                            <input type="datetime-local" name="paid_at" class="form-control <?php $__errorArgs = ['paid_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('paid_at')); ?>">
                            <?php $__errorArgs = ['paid_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3 col-md-6">
                            <label for="receipt_number" class="form-label">Receipt Number</label>
                            <input type="text" name="receipt_number" class="form-control <?php $__errorArgs = ['receipt_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('receipt_number')); ?>">
                            <?php $__errorArgs = ['receipt_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                      <?php $authUser = auth()->user(); ?>


<div class="mb-3 col-md-6">
    <label for="approved_by" class="form-label">Approved By</label>

    <?php if($authUser->hasRole('superadmin')): ?>
        <select name="approved_by" class="form-select <?php $__errorArgs = ['approved_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <option value="">(Optional)</option>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($user->id); ?>" <?php if(old('approved_by', $cotisation->approved_by ?? '') == $user->id): echo 'selected'; endif; ?>>
                    <?php echo e($user->name); ?> <?php if($user->hasRole('superadmin')): ?> (Super Admin) <?php endif; ?>
                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php else: ?>
        <input type="hidden" name="approved_by" value="<?php echo e($authUser->id); ?>">
        <input type="text" class="form-control" value="<?php echo e($authUser->name); ?>" readonly disabled>
    <?php endif; ?>

    <?php $__errorArgs = ['approved_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-danger mt-1"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="<?php echo e(route('admin.cotisations.index')); ?>" class="btn btn-secondary" onclick="rollOutCard(event, this, 'cotisation-form-card')">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Cotisation</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            const forms = document.getElementsByClassName('needs-validation');
            Array.prototype.forEach.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    function rollOutCard(event, link, cardId = 'cotisation-form-card') {
        event.preventDefault();
        const card = document.getElementById(cardId);
        if (!card) return;

        card.classList.remove('animate__rollIn', 'animate__zoomIn', 'animate__fadeInUp');
        card.classList.add('animate__animated', 'animate__rollOut');

        setTimeout(() => {
            window.location.href = link.href;
        }, 1000);
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/admin/cotisations/create.blade.php ENDPATH**/ ?>