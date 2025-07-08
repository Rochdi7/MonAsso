<?php $__env->startSection('title', 'Board Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item', 'Association'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Board Dashboard'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">
                            <i class="ph-duotone ph-trend-up me-1"></i> Member Growth (Your Association)
                        </h5>
                        <select id="member-growth-range" class="form-select form-select-sm w-auto border-0 shadow-none">
                            <option value="6">Last 6 months</option>
                            <option value="12" selected>This Year</option>
                            <option value="all">All Time</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-1">
                        <h3 class="mb-0">
                            <?php echo e($totalActiveMembers); ?> <small class="text-muted">/ total active members</small>
                        </h3>
                        <span class="badge bg-light-success ms-2">+8% this year</span>
                    </div>
                    <p>Net member growth over the selected period.</p>
                    <div id="customer-rate-graph"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ph-duotone ph-wallet me-1"></i> Cotisation Status (This Year)
                    </h5>
                </div>
                <div class="card-body">
                    <div id="overview-bar-chart"></div>
                    <div class="bg-body mt-3 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                        <p class="mb-0"><i class="ph-duotone ph-circle text-success f-12"></i> Paid</p>
                        <h5 class="mb-0 ms-1"><?php echo e(number_format($cotisationsPaidMAD, 0, '.', ' ')); ?> MAD</h5>
                    </div>
                    <div class="bg-body mt-1 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                        <p class="mb-0"><i class="ph-duotone ph-circle text-warning f-12"></i> Pending</p>
                        <h5 class="mb-0 ms-1"><?php echo e(number_format($cotisationsPendingMAD, 0, '.', ' ')); ?> MAD</h5>
                    </div>
                    <div class="bg-body mt-1 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                        <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> Overdue/Rejected</p>
                        <h5 class="mb-0 ms-1"><?php echo e(number_format($cotisationsOverdueRejectedMAD, 0, '.', ' ')); ?> MAD</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ph-duotone ph-bar-chart me-1"></i> Monthly Cotisations (Read-Only)
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">Total amount collected per month</p>
                    <h4><?php echo e(number_format(array_sum($cashflowValues->toArray()), 0, '.', ' ')); ?> MAD
                        <small class="text-muted">/ this year</small>
                    </h4>
                    <div id="monthly-report-graph"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5><i class="ph-duotone ph-calendar-blank me-1"></i> Event Participation</h5>
                    <div class="dropdown">
                        <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ph-duotone ph-dots-three-outline-vertical f-18"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Annual General Meeting</a>
                            <a class="dropdown-item" href="#">Summer Workshop</a>
                            <a class="dropdown-item" href="#">Q3 Townhall</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center g-3 text-center mb-3">
                        <div class="col-6">
                            <div class="overview-product-legends">
                                <p class="text-muted mb-1">
                                    <i class="ph-duotone ph-circle text-primary f-12"></i> Registered
                                </p>
                                <h4 class="mb-0"><?php echo e($activeEvents ?? 0); ?></h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="overview-product-legends">
                                <p class="text-muted mb-1">
                                    <i class="ph-duotone ph-circle text-success f-12"></i> Attended
                                </p>
                                <h4 class="mb-0"><?php echo e(floor(($activeEvents ?? 0) * 0.75)); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div id="yearly-summary-chart"></div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(URL::asset('build/js/plugins/apexcharts.min.js')); ?>"></script>

    <script>
        const memberGrowthData = {
            6: {
                categories: <?php echo json_encode($memberGrowthChartData[6]['categories']); ?>,
                series: [{
                    name: 'New Members',
                    data: <?php echo json_encode($memberGrowthChartData[6]['data']); ?>

                }]
            },
            12: {
                categories: <?php echo json_encode($memberGrowthChartData[12]['categories']); ?>,
                series: [{
                    name: 'New Members',
                    data: <?php echo json_encode($memberGrowthChartData[12]['data']); ?>

                }]
            },
            all: {
                categories: <?php echo json_encode($memberGrowthChartData[12]['categories']); ?>,
                series: [{
                    name: 'New Members',
                    data: <?php echo json_encode($memberGrowthChartData[12]['data']); ?>

                }]
            }
        };

        const chart = new ApexCharts(document.querySelector("#customer-rate-graph"), {
            chart: {
                type: 'line',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: memberGrowthData[12].categories
            },
            series: memberGrowthData[12].series,
            colors: ['#3b82f6']
        });

        chart.render();

        document.getElementById("member-growth-range").addEventListener("change", function() {
            const val = this.value === 'all' ? 'all' : parseInt(this.value);
            chart.updateOptions({
                xaxis: {
                    categories: memberGrowthData[val].categories
                },
                series: memberGrowthData[val].series
            });
        });
    </script>

    <script>
        const overviewChart = new ApexCharts(document.querySelector("#overview-bar-chart"), {
            chart: {
                type: 'bar',
                height: 180
            },
            series: [{
                name: 'MAD',
                data: [
                    <?php echo e($cotisationsPaidMAD); ?>,
                    <?php echo e($cotisationsPendingMAD); ?>,
                    <?php echo e($cotisationsOverdueRejectedMAD); ?>

                ]
            }],
            xaxis: {
                categories: ['Paid', 'Pending', 'Overdue/Rejected']
            },
            colors: ['#10b981', '#f59e0b', '#ef4444'],
            dataLabels: {
                enabled: false
            }
        });
        overviewChart.render();
    </script>

    <script>
        const monthlyReportChart = new ApexCharts(document.querySelector("#monthly-report-graph"), {
            chart: {
                type: 'area',
                height: 300
            },
            series: [{
                name: 'Cotisations',
                data: <?php echo json_encode($cashflowValues); ?>

            }],
            xaxis: {
                categories: <?php echo json_encode($cashflowLabels); ?>

            },
            colors: ['#22c55e'],
            dataLabels: {
                enabled: false
            }
        });
        monthlyReportChart.render();
    </script>

    <script>
        const yearlySummaryChart = new ApexCharts(document.querySelector("#yearly-summary-chart"), {
            chart: {
                type: 'donut',
                height: 280
            },
            series: [
                <?php echo e($activeEvents ?? 0); ?>,
                <?php echo e(floor(($activeEvents ?? 0) * 0.75)); ?>

            ],
            labels: ['Registered', 'Attended'],
            colors: ['#3b82f6', '#10b981'],
            dataLabels: {
                enabled: false
            }
        });
        yearlySummaryChart.render();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/admin/statistics/board.blade.php ENDPATH**/ ?>