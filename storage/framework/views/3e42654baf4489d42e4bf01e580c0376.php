<?php $__env->startSection('title', 'My Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Home'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    
    <div class="alert alert-warning" role="alert">
        <i class="ti ti-alert-triangle me-2"></i>
        Your email is not verified yet. Please check your inbox for a verification link.
    </div>

    <?php if($overdueTotal > 0 || $pendingTotal > 0): ?>
        <div class="alert alert-danger" role="alert">
            <i class="ti ti-file-invoice me-2"></i>
            You have unpaid cotisation(s) due.
            <a href="<?php echo e(route('membre.cotisations.index')); ?>" class="alert-link">Please pay now</a> to remain an active
            member.
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">

            
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="<?php echo e(asset('build/images/user/avatar-1.jpg')); ?>" alt="user image"
                                class="img-radius wid-60" />
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-1">Welcome, <?php echo e(auth()->user()->name); ?>!</h4>
                            <p class="mb-0 text-muted">Here's what's happening in your association.</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="<?php echo e(route('profile.index')); ?>" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="ti ti-user me-2"></i>My Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card table-card mb-4">
                <div class="card-header">
                    <h5>My Cotisation History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cycle</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $myCotisationsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cotisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($cotisation->cycle); ?></td>
                                        <td><?php echo e(number_format($cotisation->amount, 2)); ?> MAD</td>
                                        <td>
                                            <?php if(!empty($cotisation->due_date) && $cotisation->due_date !== 'N/A'): ?>
                                                <?php echo e(\Carbon\Carbon::parse($cotisation->due_date)->format('M d, Y')); ?>

                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $badge = match ($cotisation->status) {
                                                    1 => 'bg-light-success',
                                                    0 => 'bg-light-warning',
                                                    2 => 'bg-light-danger',
                                                    3 => 'bg-light-secondary',
                                                    default => 'bg-light-secondary',
                                                };

                                                $statusLabel = match ($cotisation->status) {
                                                    0 => 'Pending',
                                                    1 => 'Paid',
                                                    2 => 'Overdue',
                                                    3 => 'Rejected',
                                                    default => 'Unknown',
                                                };
                                            ?>
                                            <span class="badge <?php echo e($badge); ?>">
                                                <?php echo e($statusLabel); ?>

                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <?php if($cotisation->status !== 1): ?>
                                                <a href="<?php echo e(route('membre.cotisations.index')); ?>"
                                                    class="btn btn-sm btn-success d-inline-flex align-items-center">
                                                    <i class="ti ti-wallet me-1"></i>Pay Now
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('membre.cotisations.index')); ?>"
                                                    class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                                                    <i class="ti ti-receipt me-1"></i>View Receipt
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No cotisation history available.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            
            <div class="card table-card">
                <div class="card-header">
                    <h5>My Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Activity</th>
                                    <th class="text-end">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e(\Carbon\Carbon::parse($activity->date)->format('M d, Y')); ?></td>
                                        <td>
                                            <span class="badge bg-light-primary"><?php echo e($activity->type); ?></span>
                                        </td>
                                        <td class="text-end"><?php echo e($activity->details); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No recent activities.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="col-lg-4">

            
            <div class="card mb-4 bg-light-success text-center">
                <div class="card-body">
                    <h5 class="mb-2">Membership Status</h5>
                    <h3 class="text-success">ACTIVE</h3>
                    <p class="text-muted mb-0">Your payments are up to date. Thank you!</p>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>My Documents</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-secondary"><i class="ti ti-file-text f-20"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Meeting Minutes - Q1 2024</h6>
                            </div>
                            <a href="#" class="btn btn-icon btn-light-secondary"><i class="ti ti-download"></i></a>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-secondary"><i class="ti ti-file-text f-20"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Association Bylaws</h6>
                            </div>
                            <a href="#" class="btn btn-icon btn-light-secondary"><i class="ti ti-download"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Upcoming Meetings</h5>
                    <a href="<?php echo e(route('admin.meetings.index')); ?>" class="btn btn-sm btn-link-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-primary"><i class="ti ti-calendar-event f-20"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Quarterly Review</h6>
                                <small class="text-muted">Thu, Apr 18, 2024 - 06:00 PM</small>
                            </div>
                            <a href="<?php echo e(route('admin.meetings.index')); ?>" class="btn btn-icon btn-light-secondary">
                                <i class="ti ti-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Upcoming Events</h5>
                    <a href="<?php echo e(route('membre.events.index')); ?>" class="btn btn-sm btn-link-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-info"><i class="ti ti-ticket f-20"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Annual Charity Gala</h6>
                                <small class="text-muted">Sat, Jun 15, 2024</small>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <span class="badge bg-light-success">Joined</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-info"><i class="ti ti-users f-20"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Community Workshop</h6>
                                <small class="text-muted">Tue, Jul 09, 2024</small>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <span class="badge bg-light-primary">Interested</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\dashboards\member.blade.php ENDPATH**/ ?>