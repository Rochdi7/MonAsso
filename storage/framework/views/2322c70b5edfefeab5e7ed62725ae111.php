<?php $__env->startSection('title', 'Board Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Association Overview'); ?>

<?php $__env->startSection('css'); ?>
    
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/jsvectormap.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!-- Top Row: Key Performance Indicators (KPIs) -->
    <div class="row">
        
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-primary"><i class="ti ti-users f-20"></i></div>
                        <div class="ms-3">
                            <h6 class="mb-0">Total Members</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0"><?php echo e($users['total']); ?></h4>
                        <span class="badge bg-light-primary">Active: <?php echo e($users['active']); ?></span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-info"><i class="ti ti-calendar-stats f-20"></i></div>
                        <div class="ms-3">
                            <h6 class="mb-0">Meeting Attendance (Avg)</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">
                            <?php echo e($users['total'] > 0 ? round($meetings['held'] > 0 ? ($meetings['held'] / $users['total']) * 100 : 0, 1) : 0); ?>%
                        </h4>
                        <span class="badge bg-light-success"><i class="ti ti-arrow-up"></i> +5%</span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-success"><i class="ti ti-receipt-2 f-20"></i></div>
                        <div class="ms-3">
                            <h6 class="mb-0">Cotisations (YTD)</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0"><?php echo e(number_format($cotisations['total'], 0, '.', ' ')); ?> MAD</h4>
                        <span class="badge bg-light-secondary">Target: 100,000 MAD</span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-warning"><i class="ti ti-ticket f-20"></i></div>
                        <div class="ms-3">
                            <h6 class="mb-0">Upcoming Events</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0"><?php echo e($events['active']); ?></h4>
                        <span class="badge bg-light-warning">Next: 15 Days</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content and Sidebar Row -->
    <div class="row">
        
        <div class="col-lg-8">

            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Financial Performance (Last 6 Months)</h5>
                    
                </div>
                <div class="card-body">
                    <div id="financial-performance-chart"></div>
                </div>
            </div>


            
            <div class="card table-card mt-4">
                <div class="card-header">
                    <h5>Recent Meeting Performance</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Meeting Title</th>
                                    <th>Date</th>
                                    <th>Attendees</th>
                                    <th>Participation Rate</th>
                                    <th class="text-end">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($activity->details); ?></td>
                                        <td><?php echo e($activity->activity_time->format('M d, Y')); ?></td>
                                        <td>N/A</td>
                                        <td><span class="text-success">--</span></td>
                                        <td class="text-end">
                                            <a href="<?php echo e(route('admin.meetings.index')); ?>"
                                                class="btn btn-icon btn-light-secondary" title="View Meetings">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($recentActivities->isEmpty()): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No recent meetings.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

        
        <div class="col-lg-4">

            
            <div class="card h-100">
                <div class="card-header">
                    <h5>Cotisation Status (Current Cycle)</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div id="cotisation-status-chart" class="mt-3"></div>
                    <ul class="list-group list-group-flush mt-auto">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-success me-2"></i>Paid
                            </span>
                            <span class="badge bg-light-success f-w-500">
                                <?php echo e($cotisationsStatus['paid'] ?? 0); ?>

                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-warning me-2"></i>Pending
                            </span>
                            <span class="badge bg-light-warning f-w-500">
                                <?php echo e($cotisationsStatus['pending'] ?? 0); ?>

                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-danger me-2"></i>Overdue
                            </span>
                            <span class="badge bg-light-danger f-w-500">
                                <?php echo e($cotisationsStatus['overdue'] ?? 0); ?>

                            </span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(URL::asset('build/js/plugins/apexcharts.min.js')); ?>"></script>

    
    <script>
        (function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 300,
                    stacked: true,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%'
                    }
                },
                series: [{
                    name: 'Cotisations',
                    data: <?php echo json_encode($cashflowData['180']['series'][0]['data'] ?? []); ?>

                }],
                xaxis: {
                    categories: <?php echo json_encode($cashflowData['180']['categories'] ?? []); ?>

                },
                yaxis: {
                    labels: {
                        formatter: (val) => `${val.toLocaleString()} MAD`
                    }
                },
                colors: ['var(--bs-success)'],
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    markers: {
                        radius: 12
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#financial-performance-chart"), options);
            chart.render();
        })();
    </script>

    
    <script>
        (function() {
            var options = {
                chart: {
                    type: 'donut',
                    height: 250
                },
                series: [
                    <?php echo e($cotisationsStatus['paid'] ?? 0); ?>,
                    <?php echo e($cotisationsStatus['pending'] ?? 0); ?>,
                    <?php echo e($cotisationsStatus['overdue'] ?? 0); ?>

                ],
                labels: ['Paid', 'Pending', 'Overdue'],
                colors: ['var(--bs-success)', 'var(--bs-warning)', 'var(--bs-danger)'],
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                }
            };

            var chart = new ApexCharts(document.querySelector("#cotisation-status-chart"), options);
            chart.render();
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/admin/dashboards/board.blade.php ENDPATH**/ ?>