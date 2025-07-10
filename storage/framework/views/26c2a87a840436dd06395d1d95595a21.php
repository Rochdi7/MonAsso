<!DOCTYPE html>
<html lang="en">
  <!-- [Head] start -->

  <head>
    <title><?php echo $__env->yieldContent('title'); ?> | Mon Asso Laravel 11 Admin & Dashboard Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta
  name="description"
  content="Mon Asso admin and dashboard template offer a variety of UI elements and pages, ensuring your admin panel is both fast and effective."
/>
<meta name="author" content="phoenixcoded" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo e(URL::asset('build/images/favicon.svg')); ?>" type="image/x-icon">

    <?php echo $__env->yieldContent('css'); ?>

    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </head>
  <!-- [Head] end -->
  <!-- [Body] Start -->

  <body class="layout-creative" data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <?php echo $__env->make('layouts.loader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- [ Main Content ] start -->
    <div class="pc-container">
      <div class="pc-content">
        <?php if(View::hasSection('breadcrumb-item')): ?>
                <?php echo $__env->make('layouts.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <!-- [ Main Content ] start -->
            <?php echo $__env->yieldContent('content'); ?>
        <!-- [ Main Content ] end -->
      </div>
    </div>
    </div>
    <!-- [ Main Content ] end -->
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.customizer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.footerjs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
      document.querySelector('.pc-sidebar .m-header .badge').classList.add('bg-dark');
      document.querySelector('.pc-sidebar .m-header .badge').classList.remove('bg-brand-color-2');
      layout_sidebar_change('dark');
      layout_caption_change('false');
      if (document.querySelector('.pc-sidebar .m-header .logo-lg')) {
        document.querySelector('.pc-sidebar .m-header .logo-lg').setAttribute('src', '/build/images/logo-white.svg');
        document.querySelector('.pc-sidebar .m-header').classList.add('bg-brand-color-2');
      }
      function changebrand(temp){
        removeClassByPrefix(document.querySelector('.pc-sidebar .m-header'), "bg-");
        document.querySelector('.pc-sidebar .m-header').classList.add(temp);
      }
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
  </body>
  <!-- [Body] end -->
</html>
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\layouts\layout-cre.blade.php ENDPATH**/ ?>