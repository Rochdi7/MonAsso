@extends('layouts.main')

@section('title', 'Superadmin Dashboard')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Platform Overview')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/jsvectormap.min.css') }}">
@endsection

@section('content')

    {{-- Platform-wide notification remains unchanged --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">

        {{-- Top Statistics Row --}}
        {{-- Total Associations --}}
        <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-4.svg') }}" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4">Total Associations</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0">158</h3>
                    </div>
                    {{-- UPDATED: Replaced plain text with styled badges --}}
                    <div class="d-flex gap-2 text-sm mt-3 mb-2">
                        <span class="badge bg-light-success">Validated: 145</span>
                        <span class="badge bg-light-warning">Pending: 13</span>
                    </div>
                    <div class="progress" style="height: 7px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 91.7%" aria-valuenow="91.7"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Users --}}
        <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-5.svg') }}" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4">Total Users (All Roles)</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0">8,940</h3>
                    </div>
                    {{-- UPDATED: Replaced plain text with styled badges --}}
                    <div class="d-flex gap-2 text-sm mt-3 mb-2">
                        <span class="badge bg-light-success">Active: 8,512</span>
                        <span class="badge bg-light-danger">Inactive: 428</span>
                    </div>
                    <div class="progress" style="height: 7px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 95.2%" aria-valuenow="95.2"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Cotisations (Card style is unique and fine to keep) --}}
        <div class="col-md-4 col-sm-12">
            <div class="card statistics-card-1 overflow-hidden bg-primary">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-6.svg') }}" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4 text-white">Total Cotisations (Global)</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="text-white f-w-300 d-flex align-items-center m-b-0">${{ number_format(1245890.50, 2) }}
                        </h3>
                    </div>
                    <p class="text-white text-opacity-75 mb-2 text-sm mt-3">All Payments Received</p>
                    <div class="progress bg-white bg-opacity-10" style="height: 7px">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Content and Sidebar Row -->
    <div class="row">
        {{-- LEFT COLUMN (Main Content) --}}
        <div class="col-lg-8">

            {{-- Events & Meetings Summary --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Events & Meetings Summary (Platform-Wide)</h5>
                </div>
                <div class="card-body">
                    {{-- This layout is clean and minimalist, fits the theme well. No changes needed. --}}
                    <div class="row g-3">
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-none">
                                <div class="card-body p-3">
                                    <h6 class="mb-0 text-muted">Total Meetings Held</h6>
                                    <h5 class="my-2">2,510</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-none">
                                <div class="card-body p-3">
                                    <h6 class="mb-0 text-muted">Upcoming Meetings</h6>
                                    <h5 class="my-2 text-info">150</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-none">
                                <div class="card-body p-3">
                                    <h6 class="mb-0 text-muted">Total Active Events</h6>
                                    <h5 class="my-2 text-warning">88</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-none">
                                <div class="card-body p-3">
                                    <h6 class="mb-0 text-muted">Total Event Attendees</h6>
                                    <h5 class="my-2">15,432</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Global Cashflow Bar Chart --}}
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Global Cashflow (Cotisations)</h5>
                    <select id="cashflow-range" class="form-select rounded-3 form-select-sm w-auto">
                        <option value="30">Last 30 Days</option>
                        <option value="180" selected>Last 6 Months</option>
                        <option value="365">Yearly</option>
                    </select>
                </div>
                <div class="card-body">
                    <div id="cashflow-bar-chart"></div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN (Sidebar) --}}
        <div class="col-lg-4">
            {{-- Global Cotisation Status --}}
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Global Cotisation Status</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div id="cotisation-donut-chart" class="my-auto"></div>
                    {{-- UPDATED: Replaced simple list with a theme-consistent legend list for perfect consistency --}}
                    <ul class="list-group mt-4 list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0"><span
                                class="p-0 d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled text-success me-2"></i>Paid</span><span
                                class="badge bg-light-success f-w-500">9,500</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0"><span
                                class="p-0 d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled text-warning me-2"></i>Pending</span><span
                                class="badge bg-light-warning f-w-500">850</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0"><span
                                class="p-0 d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled text-danger me-2"></i>Overdue</span><span
                                class="badge bg-light-danger f-w-500">400</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0"><span
                                class="p-0 d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled text-secondary me-2"></i>Rejected</span><span
                                class="badge bg-light-secondary f-w-500">50</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Full-Width Row -->
    <div class="row">
        {{-- TOP PERFORMING ASSOCIATIONS --}}
        <div class="col-12">
            <div class="card table-card mt-4">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Top Performing Associations</h5>
                    <a href="{{ route ('admin.associations.index') }}" class="btn btn-sm btn-link-primary">View All Associations</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Association Name</th>
                                    <th>Members</th>
                                    <th>Cotisations (YTD)</th>
                                    <th>Meetings Held</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Static Rows for Associations --}}
                                <tr>
                                    <td>
                                        <h6 class="mb-0">Global Innovators Network</h6>
                                    </td>
                                    <td>452</td>
                                    <td>$42,150</td>
                                    <td>25</td>
                                    {{-- UPDATED: Used light-style badges --}}
                                    <td><span class="badge bg-light-success">Active</span></td>
                                    <td class="text-end">
                                        {{-- UPDATED: Replaced text buttons with cleaner icon buttons --}}
                                        <div class="btn-group"><a href="#" class="btn btn-icon btn-light-primary"><i
                                                    class="ti ti-eye"></i></a><a href="#"
                                                class="btn btn-icon btn-light-secondary"><i class="ti ti-settings"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="mb-0">Future Leaders Society</h6>
                                    </td>
                                    <td>1,250</td>
                                    <td>$115,200</td>
                                    <td>48</td>
                                    <td><span class="badge bg-light-success">Active</span></td>
                                    <td class="text-end">
                                        <div class="btn-group"><a href="#" class="btn btn-icon btn-light-primary"><i
                                                    class="ti ti-eye"></i></a><a href="#"
                                                class="btn btn-icon btn-light-secondary"><i class="ti ti-settings"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="mb-0">Tech Pioneers Collective</h6>
                                    </td>
                                    <td>890</td>
                                    <td>$98,500</td>
                                    <td>35</td>
                                    <td><span class="badge bg-light-success">Active</span></td>
                                    <td class="text-end">
                                        <div class="btn-group"><a href="#" class="btn btn-icon btn-light-primary"><i
                                                    class="ti ti-eye"></i></a><a href="#"
                                                class="btn btn-icon btn-light-secondary"><i class="ti ti-settings"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6 class="mb-0">Startup Hub International</h6>
                                    </td>
                                    <td>50</td>
                                    <td>$0</td>
                                    <td>0</td>
                                    <td><span class="badge bg-light-warning">Pending Approval</span></td>
                                    <td class="text-end">
                                        <div class="btn-group"><a href="#" class="btn btn-icon btn-light-warning"><i
                                                    class="ti ti-search"></i></a><a href="#"
                                                class="btn btn-icon btn-light-secondary"><i class="ti ti-settings"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>

    {{-- Donut Chart --}}
    <script>
        (function () {
            var donutOptions = {
                chart: { type: 'donut', height: 260 },
                series: [9500, 850, 400, 50],
                labels: ['Paid', 'Pending', 'Overdue', 'Rejected'],
                colors: ['var(--bs-success)', 'var(--bs-warning)', 'var(--bs-danger)', 'var(--bs-secondary)'],
                legend: { show: false },
                dataLabels: { enabled: false },
            };
            var donutChart = new ApexCharts(document.querySelector("#cotisation-donut-chart"), donutOptions);
            donutChart.render();
        })();
    </script>

    {{-- Dynamic Cashflow Chart --}}
    <script>
        const cashflowData = {
            30: {
                categories: ['Day 1', 'Day 5', 'Day 10', 'Day 15', 'Day 20', 'Day 25'],
                series: [{ name: 'Cotisations', data: [32000, 45000, 30000, 51000, 42000, 47000] }]
            },
            180: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                series: [{ name: 'Cotisations', data: [180000, 210000, 250000, 195000, 225000, 275000] }]
            },
            365: {
                categories: ['Q1', 'Q2', 'Q3', 'Q4'],
                series: [{ name: 'Cotisations', data: [560000, 630000, 710000, 740000] }]
            }
        };

        const cashflowChart = new ApexCharts(document.querySelector("#cashflow-bar-chart"), {
            chart: { type: 'bar', height: 285, toolbar: { show: false } },
            dataLabels: { enabled: false },
            colors: ['var(--bs-primary)'],
            series: cashflowData[180].series,
            xaxis: { categories: cashflowData[180].categories },
            yaxis: {
                labels: {
                    formatter: (val) => `$${val / 1000}k`
                }
            }
        });

        cashflowChart.render();

        document.getElementById('cashflow-range').addEventListener('change', function () {
            const range = this.value;
            cashflowChart.updateOptions({
                series: cashflowData[range].series,
                xaxis: { categories: cashflowData[range].categories }
            });
        });
    </script>
@endsection
