@extends('layouts.main')

@section('title', 'Global Overview')
@section('breadcrumb-item', 'Super Admin')
@section('breadcrumb-item-active', 'Global Dashboard')

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="ph-duotone ph-trend-up me-1"></i> Platform-Wide Member Growth</h5>
                <select id="member-growth-range" class="form-select form-select-sm w-auto border-0 shadow-none">
                    <option value="3">Last 3 months</option>
                    <option value="6" selected>Last 6 months</option>
                    <option value="12">This Year</option>
                </select>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <h3 class="mb-0">8,452 <small class="text-muted">/ total active members</small></h3>
                    <span class="badge bg-light-success ms-2">+1,240 this year</span>
                </div>
                <p>New member registrations across all associations.</p>
                <div id="customer-rate-graph"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="ph-duotone ph-calculator me-1"></i> Global Cotisation Status</h5></div>
            <div class="card-body">
                <div class="my-n4 text-center mx-auto" style="max-width: 150px">
                    <div id="total-earning-chart-1"></div>
                </div>
                <div class="bg-body mt-4 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                    <p class="mb-0"><i class="ph-duotone ph-circle text-success f-12"></i> Paid</p>
                    <h5 class="mb-0 ms-1">89,450 MAD</h5>
                </div>
                <div class="bg-body mt-1 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                    <p class="mb-0"><i class="ph-duotone ph-circle text-warning f-12"></i> Pending</p>
                    <h5 class="mb-0 ms-1">12,300 MAD</h5>
                </div>
                <div class="bg-body mt-1 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                    <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> Overdue / Rejected</p>
                    <h5 class="mb-0 ms-1">5,150 MAD</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="ph-duotone ph-bar-chart me-1"></i> Total Cotisations by Association</h5></div>
            <div class="card-body">
                <div id="monthly-report-graph" style="min-height: 250px;"></div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6 col-xl-4">
            <div class="card h-100" style="min-height: 320px">
                <div class="card-header"><h5 class="mb-0"><i class="ph-duotone ph-users-three me-1"></i> Users by Role</h5></div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div id="project-rating-chart"></div>
                    <div class="text-center">
                        <div class="d-inline-flex align-items-center m-1">
                            <p class="mb-0"><i class="ph-duotone ph-circle text-primary f-12"></i> Members</p>
                            <span class="badge bg-light-secondary ms-1">8,452</span>
                        </div>
                        <div class="d-inline-flex align-items-center m-1">
                            <p class="mb-0"><i class="ph-duotone ph-circle text-success f-12"></i> Admins</p>
                            <span class="badge bg-light-secondary ms-1">45</span>
                        </div>
                        <div class="d-inline-flex align-items-center m-1">
                            <p class="mb-0"><i class="ph-duotone ph-circle text-warning f-12"></i> Board</p>
                            <span class="badge bg-light-secondary ms-1">112</span>
                        </div>
                        <div class="d-inline-flex align-items-center m-1">
                            <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> Super Admins</p>
                            <span class="badge bg-light-secondary ms-1">5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card h-100" style="min-height: 320px">
                <div class="card-header"><h5 class="mb-0"><i class="ph-duotone ph-coins me-1"></i> Contributions vs. Platform Expenses</h5></div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div id="inflow-outflow-chart" style="height: 180px;"></div>
                    <div class="row text-center mt-3">
                        <div class="col-6">
                            <p class="text-muted mb-1"><i class="ph-duotone ph-circle text-success f-12"></i> Total Inflow</p>
                            <h4 class="mb-0">45,800 MAD</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1"><i class="ph-duotone ph-circle text-danger f-12"></i> Total Outflow</p>
                            <h4 class="mb-0">15,200 MAD</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100" style="min-height: 320px">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5><i class="ph-duotone ph-buildings me-1"></i> Associations Validated Over Time</h5>
                    <a href="#!" class="btn btn-sm btn-link-primary">Manage <i class="ti ti-arrow-right"></i></a>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <p>Total active associations on the platform</p>
                        <h3 class="mb-3">45 <span class="badge bg-light-success ms-2">+8 this year</span></h3>
                    </div>
                    <div id="overview-bar-chart" class="mt-auto"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>

<script>
    // Platform-Wide Member Growth Chart
    const memberGrowthData = {
        3: { categories: ['Apr', 'May', 'Jun'], series: [{ name: 'Registrations', data: [110, 140, 130] }] },
        6: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], series: [{ name: 'Registrations', data: [95, 120, 150, 110, 140, 130] }] },
        12: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], series: [{ name: 'Registrations', data: [95, 120, 150, 110, 140, 130, 155, 165, 170, 180, 190, 200] }] }
    };

    const chart = new ApexCharts(document.querySelector("#customer-rate-graph"), {
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: { categories: memberGrowthData[6].categories },
        series: memberGrowthData[6].series,
        colors: ['#2563eb']
    });
    chart.render();

    document.getElementById('member-growth-range').addEventListener('change', function () {
        const range = parseInt(this.value);
        chart.updateOptions({
            xaxis: { categories: memberGrowthData[range].categories },
            series: memberGrowthData[range].series
        });
    });

    // Inflow vs Outflow Donut Chart
    const inflowOutflowChart = new ApexCharts(document.querySelector("#inflow-outflow-chart"), {
        chart: { type: 'donut', height: 180 },
        series: [45800, 15200],
        labels: ['Inflow', 'Outflow'],
        colors: ['#16a34a', '#dc2626'],
        legend: { show: false },
        dataLabels: {
            enabled: true,
            formatter: val => val.toFixed(0) + '%'
        }
    });
    inflowOutflowChart.render();
</script>

<script src="{{ URL::asset('build/js/widgets/total-earning-chart-1.js') }}"></script> 
<script src="{{ URL::asset('build/js/widgets/monthly-report-graph.js') }}"></script> 
<script src="{{ URL::asset('build/js/widgets/project-rating-chart.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/overview-bar-chart.js') }}"></script>
@endsection
