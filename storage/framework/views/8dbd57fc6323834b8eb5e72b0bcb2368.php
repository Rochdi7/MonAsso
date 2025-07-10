<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $__env->yieldContent('title'); ?> | Mon Asso Laravel 11 Admin & Dashboard Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Mon Asso is trending dashboard template made using Laravel 11 &  Bootstrap 5 design framework. Mon Asso is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
    <meta name="keywords"
        content="Laravel 11 Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="phoenixcoded">

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo e(URL::asset('build/images/favicon.svg')); ?>" type="image/x-icon">
    <?php echo $__env->yieldContent('css'); ?>

    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">

    <?php echo $__env->make('layouts.loader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(View::hasSection('auth-v2')): ?>
        <div class="auth-main v2">
            <div class="bg-overlay bg-dark"></div>
            <div class="auth-wrapper">
                <div class="auth-sidecontent">
                    <?php echo $__env->make('layouts.authFooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            <?php else: ?>
                <div class="auth-main v1">
                    <div class="auth-wrapper">
    <?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php if(!View::hasSection('auth-v2')): ?>
        <?php echo $__env->make('layouts.authFooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    </div>
    </div>
    <?php if(View::hasSection('auth-v2')): ?>
        </div>
    <?php endif; ?>
    <?php echo $__env->make('layouts.customizer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('layouts.footerjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\layouts\AuthLayout.blade.php ENDPATH**/ ?>