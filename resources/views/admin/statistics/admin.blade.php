@extends('layouts.main')

@section('title', 'Admin Dashboard')
@section('breadcrumb-item', 'Management')
@section('breadcrumb-item-active', 'Association Dashboard')

@section('css')
@endsection

@section('content')
<div class="row g-3">
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
                    <h3 class="mb-0">210 <small class="text-muted">/ total members</small></h3>
                    <span class="badge bg-light-success ms-2">+28 since last year</span>
                </div>
                <p>New member registrations for your association over time.</p>
                <div id="customer-rate-graph"></div>
            </div>
        </div>
    </div>

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
                    <h5 class="mb-0">11,750 MAD</h5>
                </div>
                <div class="bg-body mt-2 py-2 px-3 rounded d-flex justify-content-between">
                    <p class="mb-0">
                        <i class="ph-duotone ph-circle text-warning f-12"></i> Unpaid
                    </p>
                    <h5 class="mb-0">1,200 MAD</h5>
                </div>
                <div class="bg-body mt-2 py-2 px-3 rounded d-flex justify-content-between">
                    <p class="mb-0">
                        <i class="ph-duotone ph-circle text-danger f-12"></i> Overdue
                    </p>
                    <h5 class="mb-0">450 MAD</h5>
                </div>
            </div>
        </div>
    </div>

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
                <h4 class="fw-semibold">8,450 MAD</h4>
                <div id="monthly-report-graph"></div>
            </div>
        </div>
    </div>

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
                <h4 class="fw-semibold">2,180.50 MAD</h4>
                <div id="yearly-summary-chart"></div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ph-duotone ph-handshake me-1"></i> 
                    Contributions by Type (This Year)
                </h5>
                <a href="{{ route('admin.contributions.create') }}" class="btn btn-sm btn-primary">
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
                        <h5 class="mb-0">5,000 MAD</h5>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-0">
                            <i class="ph-duotone ph-circle text-info f-12"></i> 
                            Donations
                        </p>
                        <h5 class="mb-0">1,850 MAD</h5>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-0">
                            <i class="ph-duotone ph-circle text-warning f-12"></i> 
                            Cotisations Paid
                        </p>
                        <h5 class="mb-0">12,000 MAD</h5>
                    </div>
                </div>
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
            series: [{ name: 'Registrations', data: [20, 30, 25, 35, 28, 40] }]
        },
        12: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [{ name: 'Registrations', data: [20, 30, 25, 35, 28, 40, 38, 42, 39, 45, 41, 50] }]
        },
        all: {
            categories: ['2021', '2022', '2023', '2024', '2025'],
            series: [{ name: 'Registrations', data: [180, 220, 245, 310, 385] }]
        }
    };

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
        series: memberGrowthData[12].series,
        colors: ['#2563eb']
    });

    memberChart.render();

    document.getElementById("member-growth-range").addEventListener("change", function () {
        const selected = this.value === 'all' ? 'all' : parseInt(this.value);
        memberChart.updateOptions({
            xaxis: { categories: memberGrowthData[selected].categories },
            series: memberGrowthData[selected].series
        });
    });
</script>

<script src="{{ URL::asset('build/js/widgets/total-earning-chart-1.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/monthly-report-graph.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/yearly-summary-chart.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/overview-bar-chart.js') }}"></script>
@endsection
