<?php $__env->startSection('title', 'Admin Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Association Management'); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/plugins/jsvectormap.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row align-items-center mb-3">
        <div class="col-md-8">
            <p class="text-muted mb-0">
                Manage your members, finances, and engagement for
                <strong><?php echo e($association->name); ?></strong>.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="<?php echo e(route('admin.membres.create')); ?>" class="btn btn-primary d-inline-flex align-items-center">
                <i class="ti ti-user-plus me-2"></i>Add New Member
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Member Statistics -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-primary"><i class="ti ti-users f-20"></i></div>
                        <h6 class="ms-3 mb-0">Member Statistics</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0"><?php echo e($users['total']); ?></h4>
                        <span class="badge bg-light-primary">Active: <?php echo e($users['active']); ?></span>
                    </div>
                    <div class="text-end mt-1">
                        <span class="badge bg-light-danger">Inactive: <?php echo e($users['inactive']); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cotisations -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-success"><i class="ti ti-wallet f-20"></i></div>
                        <h6 class="ms-3 mb-0">Cotisations (YTD)</h6>
                    </div>
                    <h4 class="mt-3 mb-0">
                        <?php echo e(number_format($cotisations['total'], 0, '.', ' ')); ?> MAD
                        <span class="text-success text-sm fw-normal">/ 50,000 MAD Target</span>
                    </h4>
                    <?php
                        $target = 50000;
                        $progress = $cotisations['total'] > 0
                            ? min(round(($cotisations['total'] / $target) * 100, 1), 100)
                            : 0;
                    ?>
                    <div class="progress mt-2" style="height: 7px">
                        <div class="progress-bar bg-success" role="progressbar"
                             style="width: <?php echo e($progress); ?>%"
                             aria-valuenow="<?php echo e($progress); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meetings -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-info"><i class="ti ti-calendar-event f-20"></i></div>
                        <h6 class="ms-3 mb-0">Upcoming Meetings</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0"><?php echo e($meetings['upcoming']); ?></h4>
                        <a href="<?php echo e(route('admin.meetings.create')); ?>"
                           class="btn btn-sm btn-info d-inline-flex align-items-center">
                            <i class="ti ti-calendar-plus me-1"></i> Schedule
                        </a>
                    </div>
                    <p class="text-sm text-muted mt-1 mb-0">
                        <?php if($meetings['upcoming'] > 0): ?>
                            Next meeting scheduled soon
                        <?php else: ?>
                            No upcoming meetings
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Events -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-warning"><i class="ti ti-ticket f-20"></i></div>
                        <h6 class="ms-3 mb-0">Active Events</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0"><?php echo e($events['active']); ?></h4>
                        <a href="<?php echo e(route('admin.events.create')); ?>"
                           class="btn btn-sm btn-warning d-inline-flex align-items-center">
                            <i class="ti ti-ticket-plus me-1"></i> Create
                        </a>
                    </div>
                    <p class="text-sm text-muted mt-1 mb-0">
                        Total registrations not tracked
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Cashflow Chart -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Monthly Cotisation Collection</h5>
                    <select id="cotisation-range" class="form-select rounded-3 form-select-sm w-auto">
                        <option value="30">Last 30 Days</option>
                        <option value="180" selected>Last 6 Months</option>
                        <option value="365">Yearly</option>
                    </select>
                </div>
                <div class="card-body">
                    <div id="association-cotisations-chart"></div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card table-card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Recent Member Activity</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-primary">
                                                    <i class="ti ti-user"></i>
                                                </div>
                                                <h6 class="mb-0 ms-3"><?php echo e($activity->member_name); ?></h6>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo e($activity->action); ?>

                                            <?php if($activity->details): ?>
                                                : <span class="fw-bold"><?php echo e($activity->details); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end text-muted">
                                            <small><?php echo e(\Carbon\Carbon::parse($activity->activity_time)->diffForHumans()); ?></small>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No recent activities found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('admin.events.create')); ?>"
                           class="btn btn-outline-primary d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-calendar-plus me-2"></i>Create New Event
                        </a>
                        <a href="<?php echo e(route('admin.meetings.create')); ?>"
                           class="btn btn-outline-info d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-calendar-plus me-2"></i>Schedule a Meeting
                        </a>
                        <a href="<?php echo e(route('admin.contributions.create')); ?>"
                           class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-cash me-2"></i>New Contribution
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cotisation Status Donut -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Cotisation Status</h5>
                </div>
                <div class="card-body">
                    <div id="cotisation-status-donut" class="mt-2"></div>
                    <ul class="list-group list-group-flush mt-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-success me-2"></i>Paid
                            </span>
                            <span class="badge bg-light-success f-w-500"><?php echo e($cotisationsStatus['paid']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-warning me-2"></i>Pending
                            </span>
                            <span class="badge bg-light-warning f-w-500"><?php echo e($cotisationsStatus['pending']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-danger me-2"></i>Overdue
                            </span>
                            <span class="badge bg-light-danger f-w-500"><?php echo e($cotisationsStatus['overdue']); ?></span>
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
        new ApexCharts(document.querySelector("#cotisation-status-donut"), {
            chart: { type: 'donut', height: 200 },
            series: [
                <?php echo e($cotisationsStatus['paid']); ?>,
                <?php echo e($cotisationsStatus['pending']); ?>,
                <?php echo e($cotisationsStatus['overdue']); ?>

            ],
            labels: ['Paid', 'Pending', 'Overdue'],
            colors: ['var(--bs-success)', 'var(--bs-warning)', 'var(--bs-danger)'],
            dataLabels: { enabled: false },
            legend: { show: false }
        }).render();

        const cotisationChartData = <?php echo json_encode($cashflowData, 15, 512) ?>;

        const cotisationChart = new ApexCharts(document.querySelector("#association-cotisations-chart"), {
            chart: { type: 'bar', height: 300, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 4 } },
            dataLabels: { enabled: false },
            colors: ['var(--bs-primary)'],
            series: cotisationChartData[180].series,
            xaxis: { categories: cotisationChartData[180].categories },
            yaxis: {
                labels: {
                    formatter: (val) => `${Number(val).toLocaleString()} MAD`
                }
            }
        });

        cotisationChart.render();

        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('cotisation-range');
            if (select) {
                select.addEventListener('change', function () {
                    const selected = this.value;
                    cotisationChart.updateOptions({
                        series: cotisationChartData[selected].series,
                        xaxis: { categories: cotisationChartData[selected].categories }
                    });
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\dashboards\admin.blade.php ENDPATH**/ ?>