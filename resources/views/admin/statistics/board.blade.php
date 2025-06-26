@extends('layouts.main')

@section('title', 'Board Dashboard')
@section('breadcrumb-item', 'Association')
@section('breadcrumb-item-active', 'Board Dashboard')

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="ph-duotone ph-trend-up me-1"></i> Member Growth (Your Association)</h5>
                    <select id="member-growth-range" class="form-select form-select-sm w-auto border-0 shadow-none">
                        <option value="6">Last 6 months</option>
                        <option value="12" selected>This Year</option>
                        <option value="all">All Time</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <h3 class="mb-0">210 <small class="text-muted">/ total active members</small></h3>
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
                <h5 class="mb-0"><i class="ph-duotone ph-wallet me-1"></i> Cotisation Status (This Year)</h5>
            </div>
            <div class="card-body">
                <div id="overview-bar-chart"></div>
                <div class="bg-body mt-3 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                    <p class="mb-0"><i class="ph-duotone ph-circle text-success f-12"></i> Paid</p>
                    <h5 class="mb-0 ms-1">11,750 MAD</h5>
                </div>
                <div class="bg-body mt-1 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                    <p class="mb-0"><i class="ph-duotone ph-circle text-warning f-12"></i> Pending</p>
                    <h5 class="mb-0 ms-1">1,200 MAD</h5>
                </div>
                <div class="bg-body mt-1 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                    <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> Overdue</p>
                    <h5 class="mb-0 ms-1">450 MAD</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="ph-duotone ph-bar-chart me-1"></i> Monthly Cotisations (Read-Only)</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">Total amount collected per month</p>
                <h4>11,750 MAD <small class="text-muted">/ this year</small></h4>
                <div id="monthly-report-graph"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5><i class="ph-duotone ph-calendar-blank me-1"></i> Event Participation</h5>
                <div class="dropdown">
                    <a class="avtar avtar-xs btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <p class="text-muted mb-1"><i class="ph-duotone ph-circle text-primary f-12"></i> Registered</p>
                            <h4 class="mb-0">158</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="overview-product-legends">
                            <p class="text-muted mb-1"><i class="ph-duotone ph-circle text-success f-12"></i> Attended</p>
                            <h4 class="mb-0">122</h4>
                        </div>
                    </div>
                </div>
                <div id="yearly-summary-chart"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>

<script>
    const memberGrowthData = {
        6: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            series: [{ name: 'New Members', data: [30, 42, 38, 50, 45, 55] }]
        },
        12: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [{ name: 'New Members', data: [30, 42, 38, 50, 45, 55, 48, 52, 47, 53, 49, 60] }]
        },
        all: {
            categories: ['2021', '2022', '2023', '2024', '2025'],
            series: [{ name: 'New Members', data: [180, 220, 245, 310, 385] }]
        }
    };

    const chart = new ApexCharts(document.querySelector("#customer-rate-graph"), {
        chart: {
            type: 'line',
            height: 300,
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: {
            categories: memberGrowthData[12].categories
        },
        series: memberGrowthData[12].series,
        colors: ['#3b82f6']
    });

    chart.render();

    document.getElementById("member-growth-range").addEventListener("change", function () {
        const val = this.value === 'all' ? 'all' : parseInt(this.value);
        chart.updateOptions({
            xaxis: { categories: memberGrowthData[val].categories },
            series: memberGrowthData[val].series
        });
    });
</script>

<script src="{{ URL::asset('build/js/widgets/overview-bar-chart.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/monthly-report-graph.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/yearly-summary-chart.js') }}"></script>
@endsection
