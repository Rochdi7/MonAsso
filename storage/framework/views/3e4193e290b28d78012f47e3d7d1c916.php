<?php $__env->startSection('title', 'Add Role'); ?>
<?php $__env->startSection('breadcrumb-item', 'Administration'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Add Role'); ?>
<?php $__env->startSection('page-animation', 'animate__rollIn'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/animate.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if($errors->any()): ?>
<div class="alert alert-danger animate__animated animate__shakeX">
    <ul class="mb-0">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div id="role-create-card" class="card shadow-sm animate__animated animate__rollIn">
            <div class="card-header">
                <h5 class="mb-0">Add New Role</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.roles.store')); ?>" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>
                    <div class="row">

                        <!-- Role Name -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Role Name</label>
                                <input type="text" name="name" value="<?php echo e(old('name')); ?>"
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="Enter role name" required>
                                <div class="invalid-feedback">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php else: ?> Please enter a role name. <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="col-md-12">
                            <label class="form-label">Assign Permissions</label>
                            <div class="row">
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="<?php echo e($permission->name); ?>"
                                               class="form-check-input"
                                               id="perm_<?php echo e($permission->id); ?>"
                                               <?php if(is_array(old('permissions')) && in_array($permission->name, old('permissions'))): echo 'checked'; endif; ?>>
                                        <label class="form-check-label" for="perm_<?php echo e($permission->id); ?>">
                                            <?php echo e($permission->name); ?>

                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 text-end mt-4">
                            <a href="<?php echo e(route('admin.roles.index')); ?>" class="btn btn-outline-secondary"
                               onclick="rollOutCard(event, this, 'role-create-card')">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Role</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if(session('toast')): ?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
    <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="<?php echo e(asset('assets/images/favicon.svg')); ?>" class="rounded me-2" style="width: 17px;" alt="logo">
            <strong class="me-auto">Notification</strong>
            <small>Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?php echo e(session('toast')); ?>

        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Bootstrap validation
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

    // Cancel animation
    function rollOutCard(event, link, cardId = 'role-create-card') {
        event.preventDefault();
        const card = document.getElementById(cardId);
        if (!card) return;

        card.classList.remove('animate__rollIn', 'animate__zoomIn', 'animate__fadeInUp');
        card.classList.add('animate__animated', 'animate__rollOut');

        setTimeout(() => {
            window.location.href = link.href;
        }, 1000);
    }

    // Toast auto-show
    document.addEventListener("DOMContentLoaded", function () {
        let toastEl = document.querySelector('.toast');
        if (toastEl) {
            let toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\roles\create.blade.php ENDPATH**/ ?>