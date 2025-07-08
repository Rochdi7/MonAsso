@extends('layouts.main')

@section('title', 'Supervisor Dashboard')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Operational Focus')

@section('css')
@endsection

@section('content')
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="ph-duotone ph-users-three me-1"></i> Member Growth</h5>
                <select id="member-growth-range" class="form-select form-select-sm w-auto border-0 shadow-none">
                    <option value="3">Last 3 months</option>
                    <option value="6" selected>Last 6 months</option>
                    <option value="12">This year</option>
                </select>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <h3 class="mb-0">{{ $totalNewMembers }} <small class="text-muted">/ new members</small></h3>
                    <span class="badge bg-light-success ms-2">+{{ $growthPercent }}% vs. previous period</span>
                </div>
                <p>Total new members added over the selected period.</p>
                <div id="customer-rate-graph"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 d-flex flex-column gap-3">
        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="ph-duotone ph-calendar-check me-1"></i> Meetings: Created vs. Completed</h5>
                
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <p class="text-muted mb-1"><i class="ph-duotone ph-circle text-primary f-12"></i> Created</p>
                        <h4 class="mb-0">{{ $createdMeetings }}</h4>
                    </div>
                    <div class="col-6">
                        <p class="text-muted mb-1"><i class="ph-duotone ph-circle text-success f-12"></i> Completed</p>
                        <h4 class="mb-0">{{ $completedMeetings }}</h4>
                    </div>
                </div>
                <div id="yearly-summary-chart" class="mt-3"></div>
            </div>
        </div>

        <div class="card flex-fill">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="ph-duotone ph-chart-bar me-1"></i> Events Coordinated</h5>
                <i class="ph-duotone ph-info f-20 ms-1" data-bs-toggle="tooltip" data-bs-title="Count of all coordinated events per month."></i>
            </div>
            <div class="card-body">
                @foreach ($eventTypes as $type => $count)
                    <div class="bg-body py-2 px-3 rounded d-flex justify-content-between mb-2">
                        <p class="mb-0">
                            <i class="ph-duotone ph-circle text-{{ $eventTypeColors[$type] }} f-12"></i> {{ $type }}
                        </p>
                        <h5 class="mb-0">{{ $count }}</h5>
                    </div>
                @endforeach
                <div id="overview-bar-chart" class="mt-3"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="ph-duotone ph-folder-open me-1"></i> Documents Uploaded to Meetings</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">Total files uploaded by month</p>
                <h4>{{ $documentsUploaded }} files</h4>
                <div id="monthly-report-graph"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>

<script>
    const memberGrowthData = @json($memberGrowthChartData);

    const chart = new ApexCharts(document.querySelector("#customer-rate-graph"), {
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: { categories: memberGrowthData[6].categories },
        series: [{ name: 'New Members', data: memberGrowthData[6].data }],
        colors: ['#0d6efd']
    });

    chart.render();

    document.getElementById("member-growth-range").addEventListener("change", function () {
        const val = parseInt(this.value);
        chart.updateOptions({
            xaxis: { categories: memberGrowthData[val].categories },
            series: [{ name: 'New Members', data: memberGrowthData[val].data }]
        });
    });
</script>

<script src="{{ URL::asset('build/js/widgets/yearly-summary-chart.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/monthly-report-graph.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/overview-bar-chart.js') }}"></script>
@endsection
