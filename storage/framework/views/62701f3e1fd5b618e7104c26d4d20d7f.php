<?php $__env->startSection('title', 'Layout Creative'); ?>
<?php $__env->startSection('breadcrumb-item', 'Layout'); ?>

<?php $__env->startSection('breadcrumb-item-active', 'Layout Creative'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- [ sample-page ] start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body">
                <h5>Brand Color</h5>
                <small>set background utility class in <code>.m-header</code> in sidebar</small>
                <div class="row g-3 mt-3">
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s bg-brand-color-1" onclick="changebrand('bg-brand-color-1')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s bg-brand-color-2" onclick="changebrand('bg-brand-color-2')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s bg-brand-color-3" onclick="changebrand('bg-brand-color-3')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s bg-primary" onclick="changebrand('bg-primary')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s bg-secondary" onclick="changebrand('bg-secondary')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s bg-danger" onclick="changebrand('bg-danger')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s bg-success" onclick="changebrand('bg-success')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s bg-warning" onclick="changebrand('bg-warning')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="avtar avtar-s bg-info" onclick="changebrand('bg-info')">
                      <i class="ph-duotone ph-paint-brush text-white f-18"></i>
                    </a>
                  </div>

              </div>
            </div>
          </div>
          <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.layout-cre', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\demo\layout-creative.blade.php ENDPATH**/ ?>