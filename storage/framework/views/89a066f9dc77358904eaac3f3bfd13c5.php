<!-- [ Nav ] start -->
<nav class="navbar navbar-expand-md navbar-light default">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(url('index')); ?>">
            <img src="<?php echo e(asset('assets/images/logo/monasso.png')); ?>" alt="logo" class="logo-lg landing-logo" />
        </a>
        <button class="navbar-toggler rounded" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <div class="navbar-nav ms-auto mt-lg-0 mt-2 mb-2 mb-lg-0 align-items-start">
                <a class="nav-link px-1" href="http://127.0.0.1:8000/#home">Home</a>
                <a class="nav-link px-1" href="http://127.0.0.1:8000/#features">Features</a>
                <a class="nav-link px-1" href="http://127.0.0.1:8000/#pricing">Pricing</a>
                <a class="nav-link px-1" href="http://127.0.0.1:8000/#contact">Contact</a>
            </div>

            <ul class="navbar-nav mb-2 mb-lg-0 align-items-start">
                <li class="dropdown px-1 me-2 mb-2 mb-md-0">
                    <a class="btn btn-icon btn-outline-dark border border-secondary border-opacity-25 dropdown-toggle arrow-none me-0 rounded"
                        data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ph-duotone ph-sun-dim text-warning"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                            <i class="ph-duotone ph-moon"></i>
                            <span>Dark Mode</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                            <i class="ph-duotone ph-sun-dim"></i>
                            <span>Light Mode</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                            <i class="ph-duotone ph-cpu"></i>
                            <span>Default Mode</span>
                        </a>
                    </div>
                </li>
                <?php if(auth()->guard()->check()): ?>
                    <!-- User is authenticated -->
                    <li class="nav-item">
                        <a href="<?php echo e(url('dashboard')); ?>" class="btn btn-primary">Dashboard <i
                                class="ph-duotone ph-arrow-square-out"></i></a>
                    </li>
                <?php else: ?>
                    <!-- User is not authenticated -->
                    <li class="nav-item">
                        <a href="<?php echo e(url('login')); ?>" class="btn btn-primary">Login <i
                                class="ph-duotone ph-arrow-square-out"></i></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- [ Nav ] end -->
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\layouts\component-header.blade.php ENDPATH**/ ?>