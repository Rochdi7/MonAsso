<?php $__env->startSection('title', 'Admin Dashboard'); ?>
<?php $__env->startSection('breadcrumb-item', 'Management'); ?>
<?php $__env->startSection('breadcrumb-item-active', 'Association Dashboard'); ?>

<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3">
    <!-- Member Growth -->
    <div class="col-md-6 col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="ph-duotone ph-users-four me-1"></i> 
                    Member Registration Growth
                </h5>
                <select id="member-growth-range" class="form-select form-select-sm w-auto border-0 shadow-none">
                    <option value="6">Last 6 months</option>
                    <option value="12" selected>This Year</option>
                    <option value="all">All Time</option>
                </select>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <h3 class="mb-0">
                        <?php echo e($totalMembers); ?> <small class="text-muted">/ total members</small>
                    </h3>
                    <span class="badge bg-light-success ms-2">
                        +<?php echo e($memberGrowthThisYear ?? 0); ?> since last year
                    </span>
                </div>
                <p>New member registrations for your association over time.</p>
                <div id="customer-rate-graph"></div>
            </div>
        </div>
    </div>

    <!-- Cotisation Status -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ph-duotone ph-wallet me-1"></i> 
                    Cotisation Status
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center" style="max-width: 150px; margin: auto;">
                    <div id="total-earning-chart-1"></div>
                </div>
                <div class="bg-body mt-4 py-2 px-3 rounded d-flex justify-content-between">
                    <p class="mb-0">
                        <i class="ph-duotone ph-circle text-success f-12"></i> Paid
                    </p>
                    <h5 class="mb-0"><?php echo e(number_format($cotisationsPaidMAD, 2, '.', ' ')); ?> MAD</h5>
                </div>
                <div class="bg-body mt-2 py-2 px-3 rounded d-flex justify-content-between">
                    <p class="mb-0">
                        <i class="ph-duotone ph-circle text-warning f-12"></i> Pending
                    </p>
                    <h5 class="mb-0"><?php echo e(number_format($cotisationsPendingMAD, 2, '.', ' ')); ?> MAD</h5>
                </div>
                <div class="bg-body mt-2 py-2 px-3 rounded d-flex justify-content-between">
                    <p class="mb-0">
                        <i class="ph-duotone ph-circle text-danger f-12"></i> Overdue / Rejected
                    </p>
                    <h5 class="mb-0"><?php echo e(number_format($cotisationsOverdueRejectedMAD, 2, '.', ' ')); ?> MAD</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Cotisations -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ph-duotone ph-currency-circle-dollar me-1"></i> 
                    Monthly Cotisations
                </h5>
            </div>
            <div class="card-body">
                <p>Total paid cotisations (last 6 months)</p>
                <h4 class="fw-semibold">
                    <?php echo e(number_format(array_sum($cashflowValues->toArray()), 2, '.', ' ')); ?> MAD
                </h4>
                <div id="monthly-report-graph"></div>
            </div>
        </div>
    </div>

    <!-- Monthly Expenses -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ph-duotone ph-credit-card me-1"></i> 
                    Monthly Expenses
                </h5>
            </div>
            <div class="card-body">
                <p>Recorded expenses (last 6 months)</p>
                <h4 class="fw-semibold">
                    <?php echo e(number_format($totalOutflowMAD, 2, '.', ' ')); ?> MAD
                </h4>
                <div id="yearly-summary-chart"></div>
            </div>
        </div>
    </div>

    <!-- Contributions by Type -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ph-duotone ph-handshake me-1"></i> 
                    Contributions by Type (This Year)
                </h5>
                <a href="<?php echo e(route('admin.contributions.create')); ?>" class="btn btn-sm btn-primary">
                    Add Contribution
                </a>
            </div>
            <div class="card-body">
                <div id="overview-bar-chart"></div>
                <div class="row text-center mt-4">
                    <div class="col-md-4">
                        <p class="mb-0">
                            <i class="ph-duotone ph-circle text-primary f-12"></i> 
                            Subventions
                        </p>
                        <h5 class="mb-0">
                            <?php echo e(number_format($totalInflowMAD, 2, '.', ' ')); ?> MAD
                        </h5>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-0">
                            <i class="ph-duotone ph-circle text-info f-12"></i> 
                            Donations
                        </p>
                        <h5 class="mb-0">-</h5>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-0">
                            <i class="ph-duotone ph-circle text-warning f-12"></i> 
                            Cotisations Paid
                        </p>
                        <h5 class="mb-0">
                            <?php echo e(number_format($cotisationsPaidMAD, 2, '.', ' ')); ?> MAD
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(URL::asset('build/js/plugins/apexcharts.min.js')); ?>"></script>

<script>
    const memberGrowthData = <?php echo json_encode($memberGrowthChartData, 15, 512) ?>;

    const memberChart = new ApexCharts(document.querySelector("#customer-rate-graph"), {
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: {
            categories: memberGrowthData[12].categories
        },
        series: [{
            name: 'Registrations',
            data: memberGrowthData[12].data
        }],
        colors: ['#2563eb']
    });

    memberChart.render();

    document.getElementById("member-growth-range").addEventListener("change", function () {
        const selected = this.value === 'all' ? 'all' : parseInt(this.value);
        memberChart.updateOptions({
            xaxis: { categories: memberGrowthData[selected].categories },
            series: [{
                name: 'Registrations',
                data: memberGrowthData[selected].data
            }]
        });
    });
</script>

<script>
    // Monthly cotisation graph
    const cashflowData = {
        categories: <?php echo json_encode($cashflowLabels, 15, 512) ?>,
        series: [{
            name: 'Cotisations',
            data: <?php echo json_encode($cashflowValues, 15, 512) ?>
        }]
    };

    const cotisationChart = new ApexCharts(document.querySelector("#monthly-report-graph"), {
        chart: { type: 'bar', height: 250, toolbar: { show: false } },
        plotOptions: { bar: { borderRadius: 4 } },
        dataLabels: { enabled: false },
        colors: ['#2563eb'],
        series: cashflowData.series,
        xaxis: { categories: cashflowData.categories },
        yaxis: {
            labels: {
                formatter: (val) => `${Number(val).toLocaleString()} MAD`
            }
        }
    });

    cotisationChart.render();
</script>

<script src="<?php echo e(URL::asset('build/js/widgets/total-earning-chart-1.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/widgets/yearly-summary-chart.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/widgets/overview-bar-chart.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Outlaw\Desktop\Projects\MonAsso\resources\views\admin\statistics\admin.blade.php ENDPATH**/ ?>