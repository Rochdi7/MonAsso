<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Home'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/jsvectormap.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(!auth()->user()->hasVerifiedEmail()): ?>
        <div class="alert alert-warning">
            Your email is not verified yet. Please verify your email.
        </div>
    <?php endif; ?>


    <div class="row">

        
        
        <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
                <div class="card-body">
                    <img src="<?php echo e(URL::asset('build/images/widget/img-status-4.svg')); ?>" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4">Total Associations</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0"><?php echo e($totalAssociations); ?></h3>
                    </div>
                    <p class="text-muted mb-2 text-sm mt-3">
                        Validated: <?php echo e($validatedAssociations); ?> | Pending: <?php echo e($pendingAssociations); ?>

                    </p>
                    <div class="progress" style="height: 7px">
                        <div class="progress-bar bg-brand-color-3" role="progressbar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
                <div class="card-body">
                    <img src="<?php echo e(URL::asset('build/images/widget/img-status-5.svg')); ?>" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4">Total Members</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0"><?php echo e($totalUsers); ?></h3>
                    </div>
                    <p class="text-muted mb-2 text-sm mt-3">
                        Active: <?php echo e($activeUsers); ?> | Inactive: <?php echo e($inactiveUsers); ?>

                    </p>
                    <div class="progress" style="height: 7px">
                        <div class="progress-bar bg-brand-color-3" role="progressbar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-4 col-sm-12">
            <div class="card statistics-card-1 overflow-hidden bg-brand-color-3">
                <div class="card-body">
                    <img src="<?php echo e(URL::asset('build/images/widget/img-status-6.svg')); ?>" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4 text-white">Total Cotisations</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="text-white f-w-300 d-flex align-items-center m-b-0">
                            $<?php echo e(number_format($totalCotisations, 2)); ?>

                        </h3>
                    </div>
                    <p class="text-white text-opacity-75 mb-2 text-sm mt-3">Total Payments</p>
                    <div class="progress bg-white bg-opacity-10" style="height: 7px">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 100%" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Content and Sidebar Row -->
    <div class="row">
        
        <div class="col-lg-8">

            
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Meetings Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Total Meetings</h6>
                                        <span class="text-primary fw-bold small">All</span>
                                    </div>
                                    <h5 class="my-3"><?php echo e($totalMeetings); ?></h5>
                                    <p class="text-muted mb-0">Total created meetings</p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Upcoming</h6>
                                        <span class="text-success fw-bold small">+<?php echo e($upcomingPercentage ?? '0'); ?>%</span>
                                    </div>
                                    <h5 class="my-3"><?php echo e($upcomingMeetings); ?></h5>
                                    <p class="text-muted mb-0">Upcoming scheduled</p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">This Month</h6>
                                        <span class="text-warning fw-bold small">+<?php echo e($monthPercentage ?? '0'); ?>%</span>
                                    </div>
                                    <h5 class="my-3"><?php echo e($meetingsThisMonth); ?></h5>
                                    <p class="text-muted mb-0">Meetings in current month</p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Completed</h6>
                                        <span class="text-secondary fw-bold small">Done</span>
                                    </div>
                                    <h5 class="my-3"><?php echo e($completedMeetings); ?></h5>
                                    <p class="text-muted mb-0">Meetings completed</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="mb-1">Cashflow</h5>
                            <p>5.44% <span class="badge text-bg-success">5.44%</span></p>
                        </div>
                        <select class="form-select rounded-3 form-select-sm w-auto">
                            <option>Today</option>
                            <option>Weekly</option>
                            <option selected>Monthly</option>
                        </select>
                    </div>
                    <div id="cashflow-bar-chart"></div>
                </div>
            </div>


        </div>

        
        <div class="col-lg-4">
            
            <div class="col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5>Cotisation Status</h5>
                    </div>
                    <div class="card-body">
                        <div id="cotisation-donut-chart"></div>
                        <ul class="list-group mt-4">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Paid</span>
                                <span class="badge bg-success"><?php echo e($statusCounts['paid']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Pending</span>
                                <span class="badge bg-warning"><?php echo e($statusCounts['pending']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Overdue</span>
                                <span class="badge bg-danger"><?php echo e($statusCounts['overdue']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Rejected</span>
                                <span class="badge bg-secondary"><?php echo e($statusCounts['rejected']); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Uploaded Meeting Documents</h5>
                </div>
                <div class="card-body text-center">
                    <h3><?php echo e($uploadedDocuments); ?></h3>
                    <p class="text-muted">Total Uploaded Files</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Full-Width Row -->
    <div class="row">
        
        <div class="col-12">
            <div class="card table-card mt-4">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Top Organizers</h5>
                    <a href="#" class="btn btn-sm btn-link-primary">View All</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Organizer</th>
                                    <th>Total Meetings</th>
                                    <th>This Month</th>
                                    <th>Last Meeting</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $topOrganizers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="<?php echo e($organizer->profile_image ?? asset('build/images/user/default.png')); ?>"
                                                                            alt="user image" class="img-radius wid-40" />
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h6 class="mb-0"><?php echo e($organizer->name); ?></h6>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            
                                                            <td><?php echo e($organizer->total_meetings); ?></td>

                                                            
                                                            <td><?php echo e($organizer->this_month_meetings); ?></td>

                                                            
                                                            <td>
                                                                <?php echo e($organizer->last_meeting_date
                                    ? \Carbon\Carbon::parse($organizer->last_meeting_date)->format('d M Y')
                                    : '-'); ?>

                                                            </td>

                                                            
                                                            <td>
                                                                <?php if($organizer->is_active): ?>
                                                                    <span class="badge text-bg-success">Active</span>
                                                                <?php else: ?>
                                                                    <span class="badge text-bg-danger">Inactive</span>
                                                                <?php endif; ?>
                                                            </td>

                                                            
                                                            <td>
                                                                <a href="<?php echo e(route('admin.membres.show', $organizer->id)); ?>"
                                                                    class="avtar avtar-xs btn-link-secondary">
                                                                    <i class="ti ti-eye f-20"></i>
                                                                </a>
                                                                <a href="<?php echo e(route('admin.membres.edit', $organizer->id)); ?>"
                                                                    class="avtar avtar-xs btn-link-secondary">
                                                                    <i class="ti ti-edit f-20"></i>
                                                                </a>
                                                                <form action="<?php echo e(route('admin.membres.destroy', $organizer->id)); ?>" method="POST"
                                                                    style="display:inline;">
                                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit"
                                                                        class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                                        onclick="return confirm('Delete this organizer?')">
                                                                        <i class="ti ti-trash f-20"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">No data found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(URL::asset('build/js/plugins/apexcharts.min.js')); ?>"></script>

    
    <script>
        var options = {
            series: [{
                name: 'Cotisations',
                data: <?php echo json_encode($cashflowData, 15, 512) ?>
            }],
            chart: {
                type: 'bar',
                height: 250
            },
            xaxis: {
                categories: <?php echo json_encode($cashflowLabels, 15, 512) ?>
            }
        };
        var chart = new ApexCharts(document.querySelector("#cashflow-bar-chart"), options);
        chart.render();
    </script>

    
    <script>
        var donutOptions = {
            series: [
                    <?php echo e($statusCounts['paid']); ?>,
                    <?php echo e($statusCounts['pending']); ?>,
                    <?php echo e($statusCounts['overdue']); ?>,
                <?php echo e($statusCounts['rejected']); ?>

            ],
            chart: {
                type: 'donut',
                height: 300
            },
            labels: ['Paid', 'Pending', 'Overdue', 'Rejected'],
            colors: ['#28a745', '#ffc107', '#dc3545', '#6c757d'],
        };
        var donutChart = new ApexCharts(document.querySelector("#cotisation-donut-chart"), donutOptions);
        donutChart.render();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>