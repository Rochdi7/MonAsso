@extends('layouts.main')

@section('title', 'My Dashboard')
@section('breadcrumb-item', 'Member')
@section('breadcrumb-item-active', 'My Dashboard')

@section('css')
@endsection

@section('content')
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
                        <p class="mb-0"><i class="ph-duotone ph-circle text-success f-12"></i> Total Paid</p>
                        <h5 class="mb-0">MAD 250.00</h5>
                    </div>
                    <div class="bg-body mt-2 py-2 px-3 rounded d-flex align-items-center justify-content-between">
                        <p class="mb-0"><i class="ph-duotone ph-circle text-danger f-12"></i> Total Unpaid</p>
                        <h5 class="mb-0">MAD 50.00</h5>
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
                <a href="#!" class="btn btn-sm btn-link-primary">Edit Profile <i class="ph ph-arrow-square-out ms-1"></i></a>
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

    <!-- Upcoming Meetings -->
    <div class="col-xl-4">
        <div class="card h-100 d-flex flex-column">
            <div class="card-header">
                <h5 class="mb-0"><i class="ph-duotone ph-calendar-check me-1"></i> My Upcoming Meetings & Events</h5>
            </div>
            <ul class="list-group list-group-flush flex-grow-1">
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-1">Monthly Chapter Sync</h6>
                        <small class="text-muted">3 days</small>
                    </div>
                    <p class="mb-1 text-muted">Nov 15, 2023 - Online</p>
                    <small><a href="#!">View Details</a></small>
                </li>
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-1">Annual Tech Workshop</h6>
                        <small class="text-muted">2 weeks</small>
                    </div>
                    <p class="mb-1 text-muted">Nov 28, 2023 - Main Hall</p>
                    <small><a href="#!">View Details</a></small>
                </li>
                <li class="list-group-item list-group-item-action bg-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-1">End of Year Celebration</h6>
                        <small class="text-muted">1 month</small>
                    </div>
                    <p class="mb-1 text-muted">Dec 20, 2023 - Grand Ballroom</p>
                    <small><a href="#!">RSVP Now</a></small>
                </li>
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
                <h4>MAD 250.00</h4>
                <div id="monthly-report-graph"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/total-earning-chart-1.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/project-rating-chart.js') }}"></script>

<script>
    const cotisationChartEl = document.querySelector("#monthly-report-graph");

    const chartData = {
        6: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            series: [{ name: 'Paid', data: [40, 30, 45, 35, 60, 50] }]
        },
        12: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            series: [{ name: 'Paid', data: [40, 30, 45, 35, 60, 50, 30, 40, 55, 65, 20, 45] }]
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

    const cotisationChart = new ApexCharts(cotisationChartEl, options);
    cotisationChart.render();

    document.getElementById('cotisation-range').addEventListener('change', function () {
        const val = this.value;
        cotisationChart.updateOptions({
            xaxis: { categories: chartData[val].categories },
            series: chartData[val].series
        });
    });
</script>
@endsection
