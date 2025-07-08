<?php $__env->startSection('title', 'Superadmin Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Platform Overview'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/jsvectormap.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="row">

        
        <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
                <div class="card-body">
                    <img src="<?php echo e(URL::asset('build/images/widget/img-status-4.svg')); ?>" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4">Total Associations</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0"><?php echo e($associations['total']); ?></h3>
                    </div>
                    <div class="d-flex gap-2 text-sm mt-3 mb-2">
                        <span class="badge bg-light-success">Validated: <?php echo e($associations['validated']); ?></span>
                        <span class="badge bg-light-warning">Pending: <?php echo e($associations['pending']); ?></span>
                    </div>
                    <div class="progress" style="height: 7px">
                        <div class="progress-bar bg-primary" role="progressbar"
                            style="width: <?php echo e($associations['progress']); ?>%" aria-valuenow="<?php echo e($associations['progress']); ?>"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
                <div class="card-body">
                    <img src="<?php echo e(URL::asset('build/images/widget/img-status-5.svg')); ?>" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4">Total Users (All Roles)</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0"><?php echo e($users['total']); ?></h3>
                    </div>
                    <div class="d-flex gap-2 text-sm mt-3 mb-2">
                        <span class="badge bg-light-success">Active: <?php echo e($users['active']); ?></span>
                        <span class="badge bg-light-danger">Inactive: <?php echo e($users['inactive']); ?></span>
                    </div>
                    <div class="progress" style="height: 7px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($users['progress']); ?>%"
                            aria-valuenow="<?php echo e($users['progress']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-4 col-sm-12">
            <div class="card statistics-card-1 overflow-hidden bg-primary">
                <div class="card-body">
                    <img src="<?php echo e(URL::asset('build/images/widget/img-status-6.svg')); ?>" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4 text-white">Total Cotisations (Global)</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="text-white f-w-300 d-flex align-items-center m-b-0">
                            <?php echo e(number_format($cotisations['total'], 2)); ?> MAD 
                        </h3>
                    </div>
                    <p class="text-white text-opacity-75 mb-2 text-sm mt-3">All Payments Received</p>
                    <div class="progress bg-white bg-opacity-10" style="height: 7px">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row">
        
        <div class="col-lg-8">
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Events & Meetings Summary (Platform-Wide)</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-none">
                                <div class="card-body p-3">
                                    <h6 class="mb-0 text-muted">Total Meetings Held</h6>
                                    <h5 class="my-2"><?php echo e($meetings['held']); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-none">
                                <div class="card-body p-3">
                                    <h6 class="mb-0 text-muted">Upcoming Meetings</h6>
                                    <h5 class="my-2 text-info"><?php echo e($meetings['upcoming']); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-none">
                                <div class="card-body p-3">
                                    <h6 class="mb-0 text-muted">Total Active Events</h6>
                                    <h5 class="my-2 text-warning"><?php echo e($events['active']); ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-none">
                                <div class="card-body p-3">
                                    <h6 class="mb-0 text-muted">Total Event Attendees</h6>
                                    <h5 class="my-2"><?php echo e($events['attendees']); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Global Cashflow (Cotisations)</h5>
                    <select id="cashflow-range" class="form-select rounded-3 form-select-sm w-auto">
                        <option value="30">Last 30 Days</option>
                        <option value="180" selected>Last 6 Months</option>
                        <option value="365">Yearly</option>
                    </select>
                </div>
                <div class="card-body">
                    <div id="cashflow-bar-chart"></div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Global Cotisation Status</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div id="cotisation-donut-chart" class="my-auto"></div>
                    <ul class="list-group mt-4 list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled text-success me-2"></i>Paid</span>
                            <span class="badge bg-light-success f-w-500"><?php echo e($cotisationsStatus['paid']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled text-warning me-2"></i>Pending</span>
                            <span class="badge bg-light-warning f-w-500"><?php echo e($cotisationsStatus['pending']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled text-danger me-2"></i>Overdue</span>
                            <span class="badge bg-light-danger f-w-500"><?php echo e($cotisationsStatus['overdue']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled text-secondary me-2"></i>Rejected</span>
                            <span class="badge bg-light-secondary f-w-500"><?php echo e($cotisationsStatus['rejected']); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
    <div class="col-12">
        <div class="card table-card mt-4">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="mb-0">Top Performing Associations</h5>
                <a href="<?php echo e(route('admin.associations.index')); ?>" class="btn btn-sm btn-link-primary">
                    View All Associations
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Association Name</th>
                                <th>Members</th>
                                <th>Cotisations (YTD)</th>
                                <th>Meetings Held</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $topAssociations ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <h6 class="mb-0"><?php echo e($assoc['name']); ?></h6>
                                    </td>
                                    <td><?php echo e($assoc['members']); ?></td>
                                    <td><?php echo e(number_format($assoc['cotisations'], 2)); ?> MAD</td>
                                    <td><?php echo e($assoc['meetings']); ?></td>
                                    <td>
                                        <span class="badge bg-light-<?php echo e($assoc['status_color']); ?>">
                                            <?php echo e($assoc['status_label']); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No top performing associations found.
                                    </td>
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
        (function() {
            var donutOptions = {
                chart: {
                    type: 'donut',
                    height: 260
                },
                series: [
                    <?php echo e($cotisationsStatus['paid']); ?>,
                    <?php echo e($cotisationsStatus['pending']); ?>,
                    <?php echo e($cotisationsStatus['overdue']); ?>,
                    <?php echo e($cotisationsStatus['rejected']); ?>

                ],
                labels: ['Paid', 'Pending', 'Overdue', 'Rejected'],
                colors: ['var(--bs-success)', 'var(--bs-warning)', 'var(--bs-danger)', 'var(--bs-secondary)'],
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
            };
            var donutChart = new ApexCharts(document.querySelector("#cotisation-donut-chart"), donutOptions);
            donutChart.render();
        })();

        const cashflowData = <?php echo json_encode($cashflowData, 15, 512) ?>;

        const cashflowChart = new ApexCharts(document.querySelector("#cashflow-bar-chart"), {
            chart: {
                type: 'bar',
                height: 285,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['var(--bs-primary)'],
            series: cashflowData[180].series,
            xaxis: {
                categories: cashflowData[180].categories
            },
            yaxis: {
                labels: {
                    formatter: (val) => `${val / 1000}k MAD` // UPDATED
                }
            }
        });
        cashflowChart.render();

        document.getElementById('cashflow-range').addEventListener('change', function() {
            const range = this.value;
            cashflowChart.updateOptions({
                series: cashflowData[range].series,
                xaxis: {
                    categories: cashflowData[range].categories
                }
            });
        });
    </script>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\dashboards\superadmin.blade.php ENDPATH**/ ?>