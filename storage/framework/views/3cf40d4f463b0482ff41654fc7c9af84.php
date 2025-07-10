<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
  name="description"
  content="Mon Asso admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective."
/>
<meta name="author" content="phoenixcoded" />

    <!-- Site Tiltle -->
    <title><?php echo $__env->yieldContent('title', 'Mon Asso Laravel 11 Admin & Dashboard Template'); ?></title>

    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('build/images/favicon.ico')); ?>">
    
    <?php echo $__env->yieldContent('css'); ?>

    <!-- Style Css -->
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/style.css')); ?>">
</head>
<body x-data="main" class="font-cerebri antialiased relative text-black dark:text-white text-sm font-normal overflow-x-hidden vertical detached detached-simple" :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.fullscreen ? 'full' : '',$store.app.mode]">

    <!-- Start Layout -->
    <div class="bg-[#f9fbfd] dark:bg-dark text-black">
        <!-- Start detached bg -->
        <div class="bg-[url('../images/bg-main.png')] bg-black min-h-[220px] sm:min-h-[250px] bg-bottom fixed hidden w-full -z-50 detached-img"></div>
        <!-- End detached bg -->

        <!-- Start Menu Sidebar Olverlay -->
        <div x-cloak class="fixed inset-0 bg-black/60 dark:bg-dark/90 z-[999] lg:hidden" :class="{'hidden' : !$store.app.sidebar}" @click="$store.app.toggleSidebar()"></div>
        <!-- End Menu Sidebar Olverlay -->

        <!-- Start Main Content -->
        <div class="main-container flex mx-auto">
            <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Start Content Area -->
            <div class="main-content flex-1">
                <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <!-- Start Content -->
                <div class="h-[calc(100vh-60px)]  relative overflow-y-auto overflow-x-hidden p-4 space-y-4 detached-content">
                    <!-- Start Breadcrumb -->
                    <div>
                        <nav class="w-full">
                            <ul class="space-y-2 detached-breadcrumb">
                                <li class="text-xs dark:text-white/80"><?php echo $__env->yieldContent('breadcrumb', 'Sliced'); ?></li>
                                <?php echo $__env->yieldContent('breadcrumb2'); ?>
                            </ul>
                        </nav>
                    </div>
                    <!-- End Breadcrumb -->

                    <?php echo $__env->yieldContent('content'); ?>

                    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <!-- End Content -->
            </div>
            <!-- End Content Area -->
        </div>
    </div>
    <!-- End Layout -->

    <!-- All javascirpt -->
    <!-- Alpine js -->
    <script src="<?php echo e(URL::asset('build/js/alpine-collaspe.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/alpine-persist.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/alpine.min.js')); ?>" defer></script>

    <?php echo $__env->yieldContent('scripts'); ?>

    <!-- Custom js -->
    <script src="<?php echo e(URL::asset('build/js/custom.js')); ?>"></script>

</body>
</html><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\layouts\detached.blade.php ENDPATH**/ ?>