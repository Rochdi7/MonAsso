<?php $__env->startSection('title', 'My Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item', 'Member'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'My Dashboard'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3">

    <!-- Cotisation Status -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 d-flex flex-column">
            <div class="card-header">
                <h5 class="mb-0"><i class="ph-duotone ph-wallet me-1"></i> My Cotisation Status (This Year)</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="my-n4 text-center mx-auto" style="max-width: 150px">
                    <div id="total-earning-chart-1"></div>
                </div>
                <div>
                    <div class="bg-body mt-4 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                        <p class="mb-0">
                            <i class="ph-duotone ph-circle text-success f-12"></i> Total Paid
                        </p>
                        <h5 class="mb-0">
                            MAD <?php echo e(number_format($myCotisations['paid'] ?? 0, 2)); ?>

                        </h5>
                    </div>
                    <div class="bg-body mt-2 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                        <p class="mb-0">
                            <i class="ph-duotone ph-circle text-danger f-12"></i> Total Unpaid
                        </p>
                        <h5 class="mb-0">
                            MAD <?php echo e(number_format(
                                    ($myCotisations['pending'] ?? 0)
                                    + ($myCotisations['overdue'] ?? 0)
                                    + ($myCotisations['rejected'] ?? 0), 2
                                )); ?>

                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Completeness -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 d-flex flex-column">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="ph-duotone ph-user-circle-gear me-1"></i> Profile Completeness</h5>
                <a href="<?php echo e(route('profile.index')); ?>" class="btn btn-sm btn-link-primary">
                    Edit Profile <i class="ph ph-arrow-square-out ms-1"></i>
                </a>
            </div>
            <div class="card-body d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <i class="ph-duotone ph-star text-warning me-1"></i>
                    <h3 class="mb-0">85% <small class="text-muted"> Complete</small></h3>
                </div>
                <div id="project-rating-chart"></div>
                <div class="text-center mt-3">
                    <p class="text-muted">Complete your profile to get the most out of your membership!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Meetings & Events -->
    <div class="col-xl-4">
        <div class="card h-100 d-flex flex-column">
            <div class="card-header">
                <h5 class="mb-0"><i class="ph-duotone ph-calendar-check me-1"></i> My Upcoming Meetings & Events</h5>
            </div>
            <ul class="list-group list-group-flush flex-grow-1">
                <?php $__empty_1 = true; $__currentLoopData = $upcomingMeetingsEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1"><?php echo e($item['title']); ?></h6>
                            <small class="text-muted"><?php echo e($item['time_diff']); ?></small>
                        </div>
                        <p class="mb-1 text-muted"><?php echo e($item['date']); ?> - <?php echo e($item['location']); ?></p>
                        <small><a href="<?php echo e($item['link']); ?>">View Details</a></small>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="list-group-item text-center text-muted">No upcoming meetings or events.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Cotisation History Chart -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="ph-duotone ph-chart-bar me-1"></i> My Cotisation History</h5>
                <select id="cotisation-range" class="form-select form-select-sm w-auto border-0 shadow-none">
                    <option value="6">Last 6 months</option>
                    <option value="12" selected>Last 12 months</option>
                </select>
            </div>
            <div class="card-body">
                <p class="mb-0">Total paid this year</p>
                <h4>MAD <?php echo e(number_format($myCotisations['paid'] ?? 0, 2)); ?></h4>
                <div id="monthly-report-graph"></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(URL::asset('build/js/plugins/apexcharts.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/widgets/total-earning-chart-1.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/widgets/project-rating-chart.js')); ?>"></script>

<script>
    const chartData = {
        6: {
            categories: <?php echo json_encode(array_slice($cashflowLabels, -6), 512) ?>,
            series: [{
                name: 'Paid',
                data: <?php echo json_encode(array_slice($cashflowValues->toArray(), -6), 512) ?>

            }]
        },
        12: {
            categories: <?php echo json_encode($cashflowLabels, 15, 512) ?>,
            series: [{
                name: 'Paid',
                data: <?php echo json_encode($cashflowValues, 15, 512) ?>
            }]
        }
    };

    const options = {
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: false,
                columnWidth: '40%'
            }
        },
        dataLabels: { enabled: false },
        xaxis: { categories: chartData[12].categories },
        series: chartData[12].series,
        colors: ['#16a34a']
    };

    const cotisationChart = new ApexCharts(document.querySelector("#monthly-report-graph"), options);
    cotisationChart.render();

    document.getElementById('cotisation-range').addEventListener('change', function () {
        const val = this.value;
        cotisationChart.updateOptions({
            xaxis: { categories: chartData[val].categories },
            series: chartData[val].series
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views/admin/statistics/member.blade.php ENDPATH**/ ?>