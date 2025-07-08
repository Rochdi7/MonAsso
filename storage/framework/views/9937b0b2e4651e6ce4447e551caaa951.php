<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>


            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">

                <li class="dropdown pc-h-item d-none d-md-inline-flex">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-sun-dim"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                            <i class="ph-duotone ph-moon"></i>
                            <span>Dark</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                            <i class="ph-duotone ph-sun-dim"></i>
                            <span>Light</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                            <i class="ph-duotone ph-cpu"></i>
                            <span>Default</span>
                        </a>
                    </div>
                </li>


                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        <?php
                            $user = Auth::user();
                            $media = $user->getFirstMedia('profile_photo');
                            $avatar = $media
                                ? route('media.custom', ['id' => $media->id, 'filename' => $media->file_name])
                                : asset('assets/images/user/avatar-1.jpg');
                        ?>

                        <img src="<?php echo e($avatar); ?>" alt="<?php echo e($user->name); ?>" class="user-avtar avtar avtar-s" />


                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Profile</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <ul class="list-group list-group-flush w-100">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <?php
                                                    $user = Auth::user();
                                                    $media = $user->getFirstMedia('profile_photo');
                                                    $avatar = $media
                                                        ? route('media.custom', [
                                                            'id' => $media->id,
                                                            'filename' => $media->file_name,
                                                        ])
                                                        : asset('assets/images/user/avatar-1.jpg');
                                                ?>

                                                <img src="<?php echo e($avatar); ?>" alt="<?php echo e($user->name); ?>"
                                                    class="user-avtar avtar avtar-s" />
                                            </div>

                                            <?php
                                                $user = Auth::user();
                                            ?>
                                            <div class="flex-grow-1 mx-3">
                                                <h5 class="mb-0"><?php echo e($user->name); ?></h5>
                                                <?php if($user->email): ?>
                                                    <a class="link-primary"
                                                        href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a>
                                                <?php else: ?>
                                                    <span class="text-muted small">No email provided</span>
                                                <?php endif; ?>
                                            </div>
                                            <span class="badge bg-primary">PRO</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="<?php echo e(route('profile.index')); ?>" class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-user-circle"></i>
                                                <span>Edit profile</span>
                                            </span>
                                        </a>

                                        <a href="http://127.0.0.1:8000/#pricing" class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-star text-warning"></i>
                                                <span>Upgrade account</span>
                                                <span
                                                    class="badge bg-light-success border border-success ms-2">NEW</span>
                                            </span>
                                        </a>


                                    </li>

                                    <li class="list-group-item">
                                        <a href="<?php echo e(route('logout')); ?>"
                                            onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"
                                            class="dropdown-item">
                                            <span class="d-flex align-items-center">
                                                <i class="ph-duotone ph-power"></i>
                                                <span>Logout</span>
                                            </span>
                                        </a>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                            class="d-none">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
        </div>
        </li>
        </ul>
    </div>
    </div>
</header>
<!-- [ Header ] end -->
<?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\layouts\topbar.blade.php ENDPATH**/ ?>