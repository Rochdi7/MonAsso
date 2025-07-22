<?php $__env->startSection('title', 'Account Profile'); ?>
<?php $__env->startSection('breadcrumb-item', 'Users'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Account Profile'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('status') === 'password-updated'): ?>
                <div class="alert alert-success" role="alert">
                    Password updated successfully.
                </div>
            <?php endif; ?>


            
            <?php if(!$user->hasVerifiedEmail()): ?>
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 me-3">
                                <h3 class="text-white">Email Verification</h3>
                                <p class="text-white text-opacity-75 text-opa mb-0">Your email is not confirmed. Please
                                    check your inbox.
                                    
                                <form method="POST" action="<?php echo e(route('verification.send')); ?>" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-link link-light p-0 m-0 align-baseline"><u>Resend
                                            confirmation</u></button>
                                </form>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <img src="<?php echo e(URL::asset('build/images/application/img-accout-alert.png')); ?>" alt="img"
                                    class="img-fluid wid-80" />
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-5 col-xxl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body position-relative">
                            <div class="text-center mt-3">
                                <div class="chat-avtar d-inline-flex mx-auto">
                                    <?php
                                        $media = $user->getFirstMedia('profile_photo');
                                    ?>

                                    <img class="rounded-circle img-fluid wid-90 img-thumbnail"
                                        src="<?php echo e($media
                                            ? route('media.custom', ['id' => $media->id, 'filename' => $media->file_name])
                                            : URL::asset('build/images/user/avatar-1.jpg')); ?>"
                                        alt="User image" />

                                    <i class="chat-badge bg-success me-2 mb-2"></i>
                                </div>
                                <h5 class="mb-0"><?php echo e($user->name); ?></h5>
                                <p class="text-muted text-sm">
                                    Contact <a href="mailto:<?php echo e($user->email); ?>"
                                        class="link-primary"><?php echo e($user->email); ?></a> 😍
                                </p>
                                <ul class="list-inline mx-auto my-4">
                                    
                                </ul>
                                <div class="row g-3">
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="nav flex-column nav-pills list-group list-group-flush account-pills mb-0"
                            id="user-set-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link list-group-item list-group-item-action active" id="user-set-profile-tab"
                                data-bs-toggle="pill" href="#user-set-profile" role="tab"
                                aria-controls="user-set-profile" aria-selected="true">
                                <span class="f-w-500"><i class="ph-duotone ph-user-circle m-r-10"></i>Profile
                                    Overview</span>
                            </a>
                            <a class="nav-link list-group-item list-group-item-action" id="user-set-information-tab"
                                data-bs-toggle="pill" href="#user-set-information" role="tab"
                                aria-controls="user-set-information" aria-selected="false">
                                <span class="f-w-500"><i class="ph-duotone ph-clipboard-text m-r-10"></i>Edit
                                    Information</span>
                            </a>
                            <a class="nav-link list-group-item list-group-item-action" id="user-set-password-tab"
                                data-bs-toggle="pill" href="#user-set-password" role="tab"
                                aria-controls="user-set-password" aria-selected="false">
                                <span class="f-w-500"><i class="ph-duotone ph-key m-r-10"></i>Change Password</span>
                            </a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Personal information</h5>
                        </div>
                        <div class="card-body position-relative">
                            <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                                <p class="mb-0 text-muted me-1">Email</p>
                                <p class="mb-0"><?php echo e($user->email); ?></p>
                            </div>
                            <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                                <p class="mb-0 text-muted me-1">Phone</p>
                                <p class="mb-0"><?php echo e($user->phone ?? 'Not provided'); ?></p>
                            </div>
                            <div class="d-inline-flex align-items-center justify-content-between w-100">
                                <p class="mb-0 text-muted me-1">Location</p>
                                <p class="mb-0"><?php echo e($user->location ?? 'Not provided'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-xxl-9">
                    <div class="tab-content" id="user-set-tabContent">
                        
                        <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel"
                            aria-labelledby="user-set-profile-tab">
                            <div class="card alert alert-warning p-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 me-3">
                                            <h4 class="alert-heading">Change Your Password</h4>
                                            <p class="mb-2">For your security, we recommend changing your password
                                                regularly.</p>
                                            <a href="#user-set-password" class="alert-link update-password-tab"
                                                role="tab">
                                                <u>Update your password now</u>
                                            </a>

                                        </div>
                                        <div class="flex-shrink-0">
                                            <img src="<?php echo e(URL::asset('build/images/application/img-accout-password-alert.png')); ?>"
                                                alt="Password Alert" class="img-fluid wid-80" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-header">
                                    <h5>About me</h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0"><?php echo e($user->bio ?? 'Hello! Add a bio by editing your profile.'); ?></p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5>Personal Details</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 pt-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Full Name</p>
                                                    <p class="mb-0"><?php echo e($user->name); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Email</p>
                                                    <p class="mb-0"><?php echo e($user->email); ?></p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Phone</p>
                                                    <p class="mb-0"><?php echo e($user->phone ?? 'Not provided'); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1 text-muted">Location</p>
                                                    <p class="mb-0"><?php echo e($user->location ?? 'Not provided'); ?></p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0 pb-0">
                                            <p class="mb-1 text-muted">Address</p>
                                            <p class="mb-0"><?php echo e($user->address ?? 'Not provided'); ?></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        
                        <div class="tab-pane fade" id="user-set-information" role="tabpanel"
                            aria-labelledby="user-set-information-tab">
                            <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Personal Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Full Name</label>
                                                    <input type="text"
                                                        class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        name="name" value="<?php echo e(old('name', $user->name)); ?>">
                                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Profile Photo</label>
                                                    <input type="file"
                                                        class="form-control <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        name="profile_photo">
                                                    <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Bio</label>
                                                    <textarea class="form-control <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="bio"><?php echo e(old('bio', $user->bio)); ?></textarea>
                                                    <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Contact Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Contact Phone</label>
                                                    <input type="text"
                                                        class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        name="phone" value="<?php echo e(old('phone', $user->phone)); ?>">
                                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email <span class="text-danger">(cannot be
                                                            changed)</span></label>
                                                    <input type="email" class="form-control"
                                                        value="<?php echo e($user->email); ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-0">
                                                    <label class="form-label">Address</label>
                                                    <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="address"><?php echo e(old('address', $user->address)); ?></textarea>
                                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end btn-page">
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </form>
                        </div>

                        
                        <div class="tab-pane fade" id="user-set-password" role="tabpanel"
                            aria-labelledby="user-set-password-tab">
                            <form method="POST" action="<?php echo e(route('profile.updatePassword')); ?>">
                                <?php echo csrf_field(); ?>

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>
                                    <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateLink = document.querySelector('.update-password-tab');

            if (updateLink) {
                updateLink.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Show the password tab
                    const tabTrigger = document.querySelector('#user-set-password-tab');
                    if (tabTrigger) {
                        const bsTab = new bootstrap.Tab(tabTrigger);
                        bsTab.show();

                        // Update the URL hash without reloading
                        history.pushState(null, null, '#user-set-password');

                        // Optional: Scroll to the tab content
                        setTimeout(() => {
                            const pane = document.querySelector('#user-set-password');
                            if (pane) {
                                pane.scrollIntoView({
                                    behavior: 'smooth'
                                });
                            }
                        }, 150);
                    }
                });
            }

            // Auto-activate tab if URL already contains the hash
            if (window.location.hash === '#user-set-password') {
                const tabTrigger = document.querySelector('#user-set-password-tab');
                if (tabTrigger) {
                    const bsTab = new bootstrap.Tab(tabTrigger);
                    bsTab.show();
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/profile/index.blade.php ENDPATH**/ ?>