<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="m-header">
        <a href="//index" class="b-brand text-primary">
            <!-- ========   Change your logo from here   ============ -->
            <img src="<?php echo e(URL::asset('build/images/logo-white.svg')); ?>" alt="logo image" class="logo-lg" />
            <span class="badge bg-brand-color-2 rounded-pill ms-1 theme-version">v1.0.0</span>
        </a>
    </div>
    <div class="header-wrapper"> <?php echo $__env->make('layouts.topbar-d', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></div>
</header>
<!-- [ Header ] end -->
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\layouts\topbar-detached.blade.php ENDPATH**/ ?>