<?php $__env->startSection('title', '404'); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-form">
        <div class="error-card">
            <div class="card-body">
                <div class="error-image-block">
                    <img class="img-fluid" src="<?php echo e(URL::asset('build/images/pages/img-error-404.png')); ?>" alt="img" />
                </div>
                <div class="text-center">
                    <h1 class="mt-2">Oops! Something Went wrong</h1>
                    <p class="mt-2 mb-4 text-muted f-20">We couldn’t find the page you were looking for. Why not try back to
                        the Homepage.</p>
                    <a class="btn btn-primary d-inline-flex align-items-center mb-3" href="/dashboard/index"><i
                            class="ph-duotone ph-house me-2"></i> Back to Home</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.AuthLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/errors/404.blade.php ENDPATH**/ ?>