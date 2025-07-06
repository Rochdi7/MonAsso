<!-- Required Js -->
<script src="<?php echo e(URL::asset('build/js/plugins/popper.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/plugins/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/plugins/i18next.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/plugins/i18nextHttpBackend.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/icon/custom-font.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/script.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/theme.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/multi-lang.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/plugins/feather.min.js')); ?>"></script>

<?php if(env('APP_DARK_LAYOUT') == 'default'): ?>
<script>
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        dark_layout = 'true';
    } else {
        dark_layout = 'false';
    }
    layout_change_default();
    if (dark_layout == 'true') {
        layout_change('dark');
    } else {
        layout_change('light');
    }
</script>
<?php endif; ?>

<?php if(env('APP_DARK_LAYOUT') != 'default'): ?>
    <?php if(env('APP_DARK_LAYOUT') == 'true'): ?>
        <script>
            layout_change('dark');
        </script>
    <?php endif; ?>
    <?php if(env('APP_DARK_LAYOUT') == false): ?>
        <script>
            layout_change('light');
        </script>
    <?php endif; ?>
<?php endif; ?>


<?php if(env('APP_DARK_NAVBAR') == 'true'): ?>
    <script>
        layout_sidebar_change('dark');
    </script>
<?php endif; ?>

<?php if(env('APP_DARK_NAVBAR') == false): ?>
    <script>
        layout_sidebar_change('light');
    </script>
<?php endif; ?>

<?php if(env('APP_BOX_CONTAINER') == false): ?>
    <script>
        change_box_container('true');
    </script>
<?php endif; ?>

<?php if(env('APP_BOX_CONTAINER') == false): ?>
    <script>
        change_box_container('false');
    </script>
<?php endif; ?>

<?php if(env('APP_CAPTION_SHOW') == 'true'): ?>
    <script>
        layout_caption_change('true');
    </script>
<?php endif; ?>

<?php if(env('APP_CAPTION_SHOW') == false): ?>
    <script>
        layout_caption_change('false');
    </script>
<?php endif; ?>

<?php if(env('APP_RTL_LAYOUT') == 'true'): ?>
    <script>
        layout_rtl_change('true');
    </script>
<?php endif; ?>

<?php if(env('APP_RTL_LAYOUT') == false): ?>
    <script>
        layout_rtl_change('false');
    </script>
<?php endif; ?>

<?php if(env('APP_PRESET_THEME') != ''): ?>
    <script>
        preset_change("<?php echo e(env('APP_PRESET_THEME')); ?>");
    </script>
<?php endif; ?>
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\layouts\footerjs.blade.php ENDPATH**/ ?>