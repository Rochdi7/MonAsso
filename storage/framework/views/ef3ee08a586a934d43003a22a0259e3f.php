<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="//index" class="b-brand">
                <!-- ========   Change your logo from here   ============ -->
                <img src="<?php echo e(asset('assets/images/logo/monasso.png')); ?>" alt="" class="logo logo-lg">
                <img src="<?php echo e(URL::asset('build/images/favicon.svg')); ?>" alt="" class="logo logo-sm">
            </a>
        </div>
        <div class="tab-container">
            <div class="tab-sidemenu">
                <ul class="pc-tab-link nav flex-column" role="tablist" id="pc-layout-submenus">
                </ul>
            </div>
            <div class="tab-link">
                <div class="navbar-content">
                    <div class="tab-content" id="pc-layout-tab">
                    </div>
                    <ul class="pc-navbar">
                        <?php echo $__env->make('layouts.menu-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\layouts\sidebar-tab.blade.php ENDPATH**/ ?>