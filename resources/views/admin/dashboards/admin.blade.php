@extends('layouts.main')

@section('title', 'Admin Dashboard')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Association Management')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/jsvectormap.min.css') }}">
@endsection

@section('content')
    <div class="row align-items-center mb-3">
        <div class="col-md-8">
            <p class="text-muted mb-0">Manage your members, finances, and engagement from here.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.membres.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                <i class="ti ti-user-plus me-2"></i>Add New Member
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-primary"><i class="ti ti-users f-20"></i></div>
                        <h6 class="ms-3 mb-0">Member Statistics</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">452</h4>
                        <span class="badge bg-light-primary">Active: 418</span>
                    </div>
                    <div class="text-end mt-1">
                        <span class="badge bg-light-danger">Inactive: 34</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-success"><i class="ti ti-wallet f-20"></i></div>
                        <h6 class="ms-3 mb-0">Cotisations (YTD)</h6>
                    </div>
                    <h4 class="mt-3 mb-0">42,150 MAD <span class="text-success text-sm fw-normal">/ 50,000 MAD Target</span></h4>
                    <div class="progress mt-2" style="height: 7px">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 84.3%" aria-valuenow="84.3"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-info"><i class="ti ti-calendar-event f-20"></i></div>
                        <h6 class="ms-3 mb-0">Upcoming Meetings</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">3</h4>
                        <a href="{{ route('admin.meetings.create') }}"
                            class="btn btn-sm btn-info d-inline-flex align-items-center">
                            <i class="ti ti-calendar-plus me-1"></i> Schedule
                        </a>
                    </div>
                    <p class="text-sm text-muted mt-1 mb-0">Next: "Q2 Review" in 5 days</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-warning"><i class="ti ti-ticket f-20"></i></div>
                        <h6 class="ms-3 mb-0">Active Events</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">2</h4>
                        <a href="{{ route('admin.events.create') }}"
                            class="btn btn-sm btn-warning d-inline-flex align-items-center">
                            <i class="ti ti-ticket-plus me-1"></i> Create
                        </a>
                    </div>
                    <p class="text-sm text-muted mt-1 mb-0">Total registrations: 124</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
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

            <div class="card table-card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Recent Member Activity</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('build/images/user/avatar-1.jpg') }}" alt="user" class="img-radius wid-40" />
                                            <h6 class="mb-0 ms-3">Jane Doe</h6>
                                        </div>
                                    </td>
                                    <td>Paid their <span class="fw-bold">Annual Dues 2024</span></td>
                                    <td class="text-end text-muted"><small>5 minutes ago</small></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('build/images/user/avatar-2.jpg') }}" alt="user" class="img-radius wid-40" />
                                            <h6 class="mb-0 ms-3">John Smith</h6>
                                        </div>
                                    </td>
                                    <td>Registered as a new member</td>
                                    <td class="text-end text-muted"><small>2 hours ago</small></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avtar avtar-s bg-light-secondary"><i class="ti ti-user-shield"></i></div>
                                            <h6 class="mb-0 ms-3">Admin User</h6>
                                        </div>
                                    </td>
                                    <td>Created event: <span class="fw-bold">"Summer Mixer"</span></td>
                                    <td class="text-end text-muted"><small>1 day ago</small></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('build/images/user/avatar-4.jpg') }}" alt="user" class="img-radius wid-40" />
                                            <h6 class="mb-0 ms-3">Michael B.</h6>
                                        </div>
                                    </td>
                                    <td>Attended "Q1 Financial Review" meeting</td>
                                    <td class="text-end text-muted"><small>3 days ago</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.events.create') }}"
                            class="btn btn-outline-primary d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-calendar-plus me-2"></i>Create New Event
                        </a>
                        <a href="{{ route('admin.meetings.create') }}"
                            class="btn btn-outline-info d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-calendar-plus me-2"></i>Schedule a Meeting
                        </a>
                        <a href="{{ route('admin.contributions.create') }}"
                            class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-cash me-2"></i>New Contribution
                        </a>
                    </div>
                </div>
            </div>

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
                            <span class="badge bg-light-success f-w-500">420</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-warning me-2"></i>Pending
                            </span>
                            <span class="badge bg-light-warning f-w-500">25</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-danger me-2"></i>Overdue
                            </span>
                            <span class="badge bg-light-danger f-w-500">7</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>
    <script>
        new ApexCharts(document.querySelector("#cotisation-status-donut"), {
            chart: { type: 'donut', height: 200 },
            series: [420, 25, 7],
            labels: ['Paid', 'Pending', 'Overdue'],
            colors: ['var(--bs-success)', 'var(--bs-warning)', 'var(--bs-danger)'],
            dataLabels: { enabled: false },
            legend: { show: false }
        }).render();

        const cotisationChartData = {
            30: {
                categories: ['Day 1', 'Day 5', 'Day 10', 'Day 15', 'Day 20', 'Day 25'],
                series: [{ name: 'Cotisations', data: [3200, 4500, 3900, 5000, 4700, 5200] }]
            },
            180: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                series: [{ name: 'Cotisations', data: [5500, 6200, 7800, 9500, 8100, 11000] }]
            },
            365: {
                categories: ['Q1', 'Q2', 'Q3', 'Q4'],
                series: [{ name: 'Cotisations', data: [18000, 21000, 25000, 30000] }]
            }
        };

        const cotisationChart = new ApexCharts(document.querySelector("#association-cotisations-chart"), {
            chart: { type: 'bar', height: 300, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 4 } },
            dataLabels: { enabled: false },
            colors: ['var(--bs-primary)'],
            series: cotisationChartData[180].series,
            xaxis: { categories: cotisationChartData[180].categories },
            yaxis: {
                labels: {
                    formatter: (val) => `${val.toLocaleString()} MAD`
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
@endsection
