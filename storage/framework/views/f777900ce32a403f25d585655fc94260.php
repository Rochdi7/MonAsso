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
    <div class="navbar-content">
      <ul class="pc-navbar">
        <?php echo $__env->make('layouts.menu-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </ul>
    </div>
    <div class="pc-compact-submenu">
      <div class="pc-compact-title">
        <div class="d-flex align-items-center">
          <div class="flex-shrink-0">
            <div class="avtar avtar-xs bg-light-primary">
              <i class=""></i>
            </div>
          </div>
          <div class="flex-grow-1 ms-2">
            <h5 class="mb-0">title</h5>
          </div>
        </div>
      </div>
      <div class="pc-compact-list"></div>
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\layouts\sidebar-compact.blade.php ENDPATH**/ ?>