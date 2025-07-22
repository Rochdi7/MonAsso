<?php $__env->startSection('title', 'Create Contribution'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'New Contribution'); ?>
<?php $__env->startSection('page-animation', 'animate__rollIn'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/datepicker-bs5.min.css')); ?>">
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

            <form action="<?php echo e(route('admin.contributions.store')); ?>" method="POST" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>

                <div id="contribution-form-card" class="card animate__animated animate__rollIn">
                    <div class="card-header">
                        <h5>New Contribution Form</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="type" class="form-label">Contribution Type</label>
                                <select name="type" class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Select type...</option>
                                    <option value="1" <?php if(old('type') == 1): echo 'selected'; endif; ?>>Subvention</option>
                                    <option value="2" <?php if(old('type') == 2): echo 'selected'; endif; ?>>Don</option>
                                </select>
                                <?php $__errorArgs = ['type'];
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
                                <input type="number" step="0.01" name="amount"
                                    class="form-control <?php $__errorArgs = ['amount'];
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

                            <?php $auth = $authUser; ?>

<?php if($auth->hasRole('superadmin')): ?>
    <div class="mb-3 col-md-6">
        <label for="association_id" class="form-label">Association</label>
        <select name="association_id"
                class="form-select <?php $__errorArgs = ['association_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
            <option value="">Choose association...</option>
            <?php $__currentLoopData = $associations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($id); ?>" <?php if(old('association_id') == $id): echo 'selected'; endif; ?>>
                    <?php echo e($name); ?>

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
    <input type="hidden" name="association_id" value="<?php echo e($auth->association_id); ?>">
<?php endif; ?>


                            <div class="mb-3 col-md-6">
                                <label for="received_at" class="form-label">Received At</label>
                                <input type="date" name="received_at"
                                    class="form-control <?php $__errorArgs = ['received_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('received_at')); ?>">
                                <?php $__errorArgs = ['received_at'];
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

                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" rows="4"
                                    class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="Enter description..."><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
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
                        <a href="<?php echo e(route('admin.contributions.index')); ?>" class="btn btn-secondary"
                            onclick="rollOutCard(event, this, 'contribution-form-card')">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Contribution</button>
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

        function rollOutCard(event, link, cardId = 'contribution-form-card') {
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

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/admin/contributions/create.blade.php ENDPATH**/ ?>