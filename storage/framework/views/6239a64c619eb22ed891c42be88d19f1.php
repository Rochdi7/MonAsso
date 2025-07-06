<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="//index" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="<?php echo e(asset('assets/images/logo/monasso.png')); ?>" alt="logo image" class="logo-lg">
                <span class="badge bg-brand-color-2 rounded-pill ms-1 theme-version">v1.0.0</span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <?php echo $__env->make('layouts.menu-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </ul>
            <div class="card nav-action-card bg-brand-color-4">
                <div class="card-body" style="background-image: url('/build/images/layout/nav-card-bg.svg')">
                    <h5 class="text-dark">User Guide</h5>
                    <p class="text-dark text-opacity-75">Learn how to use the platform step by step.</p>
                    <a href="<?php echo e(route('user-guide')); ?>" class="btn btn-primary">View Guide</a>
                </div>
            </div>


        </div>
        <div class="card pc-user-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <?php
                            $user = Auth::user();
                            $media = $user->getFirstMedia('profile_photo');
                            $profilePhoto = $media
                                ? route('media.custom', ['id' => $media->id, 'filename' => $media->file_name])
                                : asset('assets/images/user/avatar-1.jpg');
                        ?>

                        <img src="<?php echo e($profilePhoto); ?>" alt="user-image" class="user-avtar wid-45 rounded-circle">

                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="dropdown">
                            <a href="#" class="arrow-none dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false" data-bs-offset="0,20">
                                <div class="d-flex align-items-center">
                                    <?php
                                        $user = Auth::user();
                                        $role = $user->getRoleNames()->first() ?? 'User';
                                    ?>

                                    <div class="flex-grow-1 me-2">
                                        <h6 class="mb-0"><?php echo e($user->name); ?></h6>
                                        <small class="text-muted text-uppercase"><?php echo e($role); ?></small>
                                    </div>

                                    <div class="flex-shrink-0">
                                        <div class="btn btn-icon btn-link-secondary avtar">
                                            <i class="ph-duotone ph-windows-logo"></i>
                                        </div>
                                    </div>
                                </div>

                            </a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li>
                                        <a href="<?php echo e(route('profile.index')); ?>" class="pc-user-links">
                                            <i class="ph-duotone ph-user"></i>
                                            <span>My Account</span>
                                        </a>
                                    </li>


                                    <a class="pc-user-links" href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                        <i class="ph-duotone ph-power"></i>
                                        <span>Logout</span>
                                    </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>